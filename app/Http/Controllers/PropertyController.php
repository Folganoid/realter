<?php

namespace App\Http\Controllers;

use App\Document;
use App\House;
use App\Image;
use App\Watch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
use Illuminate\Support\Facades\Config;
use League\Flysystem\Exception;

class PropertyController extends Controller
{
    /**
     * show add page
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function add()
    {
        if (Gate::denies('is-agent')) {
            return redirect()->route('home')->with(['status' => 'You are not agent!', 'class' => 'danger']);
        }

        return view('property_add')->with([
            'types' => $this->types,
            'rent' => (['0' => ''] + $this->rent),
            'operation' => $this->operation,
            'square' => $this->square
        ]);
    }

    /**
     * show enhanced view one house by id
     *
     * @param $id
     */
    public function view($id)
    {
        $property = House::where('id', $id)->with(['image', 'document', 'watch', 'user'])->first()->toArray();
        $watches = null;

        if ($property['user_id'] == Auth::id() || Gate::allows('is-admin')) {
            $watches = Watch::where('house_id', $id)->with('user')->get()->toArray();
        }

        if (Auth::check() && $property['user_id'] != Auth::id()) {

            /**
             * if user has entered today
             */
            $watchToday = Watch::where('user_id', '=', Auth::id())->where('house_id', '=', $id)->
            where('created_at', '>', substr(date(now()), 0, 10) . ' 00:00:00')->
            where('created_at', '<', substr(date(now()), 0, 10) . ' 23:59:59')->
            first();
            $watch = (!empty($watchToday)) ? $watchToday : new Watch();
            $watch->house_id = $id;
            $watch->user_id = Auth::id();
            $watch->created_at = date(now());
            $watch->save();
        }

        return view('property_view_one')->with([
            'property' => $property,
            'watch' => $watches,
            'types' => $this->types,
            'rent' => $this->rent,
            'square' => $this->square,
            'operation' => $this->operation
        ]);
    }

    /**
     * save added property in DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        /**
         * validator
         */
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'address' => 'required',
            'openview_min' => 'max:3',
            'price' => [
                'required',
                'regex:/^[1-9]\d{0,10}(?:\.\d{0,2})?$/',
            ],
            'square' => [
                'required',
                'regex:/^[1-9]\d{0,8}(?:\.\d{0,2})?$/',
            ],
            'image' => 'max:2000000'
        ]);

        $data = $request->all();
        $lastId = $this->saveToHouseTable($data, new House());

        if(!$lastId) return redirect()->route('property.view', ['id' => $data['id']])->with(['status' => 'Error', 'class' => 'danger']);

        /**
         * Save image to cloud & DB
         */
        if ($request->file('image')) {
            if ($request->file('image')->isValid()) {
                try {
                    $this->saveImage($data, $lastId, $data['image']);
                }
                catch (Exception $e) {
                    return redirect()->route('cabinet')->with(['status' => $e->getMessage(), 'class' => 'danger']);
                };
            }
        }

        return redirect()->route('cabinet')->with(['status' => 'Property added', 'class' => 'success']);
    }


    /**
     * delete property by id
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {

        $property = House::find($id);

        if ($property['user_id'] != Auth::id()) {
            if (Gate::denies('is-admin')) {
                return redirect()->route('home')->with(['status' => 'Access denied', 'class' => 'danger']);
            }
        }

        $tmpArr = [];

        try {
            $docs = Document::where('house_id', $id)->select('path')->get()->toArray();
            for ($i = 0; $i < count($docs); $i++) {
                $tmpArr[] = substr($docs[$i]['path'], 0, strrpos($docs[$i]['path'], '.'));
            }

            $imgs = Image::where('house_id', $id)->select('path')->get()->toArray();
            for ($i = 0; $i < count($imgs); $i++) {
                $tmpArr[] = substr($imgs[$i]['path'], 0, strrpos($imgs[$i]['path'], '.'));
            }

            Watch::where('house_id', $id)->delete();
            Document::where('house_id', $id)->delete();
            Image::where('house_id', $id)->delete();
            House::destroy($id);

            $cloud = new \Cloudinary\Api();
            $cloud->delete_resources($tmpArr);
        }
        catch(Exception $e) {
            return redirect()->route('cabinet')->with(['status' => 'Property did not delete!', 'class' => 'danger']);
        }

        return redirect()->route('cabinet')->with(['status' => 'Property was deleted', 'class' => 'success']);
    }


    /**
     * property edit page
     *
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $property = House::where('id', $id)->with(['image', 'document'])->first()->toArray();

        if ($property['user_id'] != Auth::id()) {
            if (Gate::denies('is-admin')) {
                return redirect()->route('home')->with(['status' => 'You do not have access', 'class' => 'danger']);
            }
        }

        return view('property_edit')->with([
            'property' => $property,
            'types' => $this->types,
            'rent' => (['0' => ''] + $this->rent),
            'square' => $this->square,
            'operation' => $this->operation
        ]);
    }

    public function editSave(Request $request)
    {
        /**
         * validator
         */
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required',
            'address' => 'required',
            'openview_min' => 'max:3',
            'price' => [
                'required',
                'regex:/^[1-9]\d{0,10}(?:\.\d{0,2})?$/',
            ],
            'square' => [
                'required',
                'regex:/^[1-9]\d{0,8}(?:\.\d{0,2})?$/',
            ],
            'image' => 'max:2000000',
            'document' => 'max:2000000'
        ]);

        $data = $request->all();
        $house = House::find($data['id']);

        if ($house['user_id'] != Auth::id()) {
            if (Gate::denies('is-admin')) {
                return redirect()->route('property.view', ['id' => $data['id']])->with(['status' => 'You do not have access', 'class' => 'danger']);
            }
        }

        $save = $this->saveToHouseTable($data, $house);
        if(!$save) return redirect()->route('property.view', ['id' => $data['id']])->with(['status' => 'Access denied', 'class' => 'danger']);

        $errors = 0;
        /**
         * save images
         */
        if(isset($data['image'])) {
            for ($z = 0; $z < count($data['image']); $z++) {
                try {
                    $this->saveImage($data, $data['id'], $data['image'][$z]);
                } catch (Exception $e) {
                    $errors++;
                };
            }
        }

        /**
         * save docs
         */
        if(isset($data['document'])) {

            for ($d = 0; $d < count($data['document']); $d++) {
                try {
                    $this->saveDocument($data, $data['id'], $data['document'][$d]);
                } catch (Exception $e) {
                    $errors++;
                };
            }

            if ($errors > 0) {
                return redirect()->route('property.view', ['id' => $data['id']])->with(['status' => $errors . ' files not loaded ! (bad format or filesize over 2MB)', 'class' => 'danger']);
            }
        }

        return redirect()->route('property.view', ['id' => $data['id']])->with(['status' => 'Data changed', 'class' => 'success']);
    }

    /**
     * save to housetale & return last ID
     *
     * @param $data
     * @return mixed
     */
    public function saveToHouseTable($data, House $house)
    {
        $timestamp = null;

        if ($data['openview_date'] && $data['openview_time']) {
            $timestamp = $data['openview_date'] . ' ' . $data['openview_time'] . ':00';
        }

        $house->name = $data['name'];
        $house->user_id = (isset($data['user_id'])) ? $data['user_id'] : Auth::id();
        $house->desc = $data['description'];
        $house->price = $data['price'];
        $house->square = $data['square'];
        $house->address = $data['address'];
        $house->operation = $data['operation'];
        $house->name = $data['name'];
        $house->house_type_id = $data['house_type_id'];
        $house->openview = $timestamp;
        $house->openview_min = ($timestamp) ? $data['openview_min'] : null;
        $house->operation_measure_id = ($data['rent_measure'] > 0) ? $data['rent_measure'] : null;
        $house->square_measure_id = $data['square_measure'];

        if ($house->user_id != Auth::id()) {
            if (Gate::denies('is-admin')) {
                return false;
            }
        }

        $house->save();
        return $house->id;
    }

    /**
     * save image to cloud & DB
     *
     * @param $data
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveImage($data, $id, $img) {

        try {
            $width = getimagesize($img)[0];
            $result = \Cloudinary\Uploader::upload($img, [
                "crop" => "fill",
                "width" => ($width < Config::get('settings.cloudinary')['max_width']) ? $width : Config::get('settings.cloudinary')['max_width'],
                "format" => "jpg"
            ]);
        } catch (\Exception $e) {
            throw new Exception('Can not upload Image');
        }

        try {
            $image = new Image();
            $image->name = $data['name'];
            $image->path = $result['public_id']. '.' . $result['format'];
            $image->house_id = $id;
            $image->save();

        } catch (Exception $e) {
            throw new Exception('Can not upload in Data Base');
        }

    }

    /**
     * save document to cloud & db
     *
     * @param $data
     * @param $id
     * @param $doc
     * @throws Exception
     */
    public function saveDocument($data, $id, $doc) {

        try {
            $result = \Cloudinary\Uploader::upload($doc);
        } catch (\Exception $e) {
            throw new Exception('Can not upload Document');
        }

        try {

            $document = new Document();
            $document->name = $data['name'];
            $document->path = $result['public_id'] . '.' . $result['format'];
            $document->house_id = $id;
            $document->save();

        } catch (Exception $e) {
            throw new Exception('Can not upload in Data Base');
        }

    }
}
