<?php

namespace App\Http\Controllers;

use App\Document;
use App\House;
use App\House_type;
use App\Image;
use App\Watch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;

class PropertyController extends Controller
{
    //
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
     * enhanced view one house by id
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
            $watch = new Watch();
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

        $data = $request->all();
        $timestamp = null;

        if ($data['openview_date'] && $data['openview_time']) {
            $timestamp = $data['openview_date'] . ' ' . $data['openview_time'] . ':00';
        }

        $house = new House();
        $house->name = $data['name'];
        $house->desc = $data['description'];
        $house->user_id = Auth::id();
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

        $house->save();
        $lastId = $house->id;

        if ($data['image']) {
            $image = new Image();
            $image->name = $data['name'];
            $image->path = $data['image'];
            $image->house_id = $lastId;
            $image->save();
        }

        if ($data['doc']) {
            $image = new Document();
            $image->name = $data['name'];
            $image->path = $data['doc'];
            $image->house_id = $lastId;
            $image->save();
        }
        return redirect()->route('cabinet')->with(['status' => 'Property added', 'class' => 'success']);
    }
}
