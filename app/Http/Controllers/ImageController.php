<?php

namespace App\Http\Controllers;

use App\House;
use App\Image;
use Illuminate\Http\Request;
use Auth;
use Gate;
use League\Flysystem\Exception;

class ImageController extends Controller
{
    /**
     * delete img from cloud & DB
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {

        try {
            $img = Image::find($id);
            $house = House::find($img->house_id);

            if ($house->user_id != Auth::id()) {
                if (Gate::denies('is-admin')) {
                    return response()->json('{"status": "false"}');
                }
            }

            \Cloudinary\Uploader::destroy($img->path);
            $img->delete();
            return response()->json('{"status": "ok"}');
        }
        catch (Exception $e){
            return response()->json('{"status": "false"}');
        }
    }

    /**
     * update image name
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request) {

        try {
            $data = $request->all();
            $img = Image::find($data['id']);

            $house = House::find($img->house_id);

            if ($house->user_id != Auth::id()) {
                if (Gate::denies('is-admin')) {
                    return response()->json('{"status": "false"}');
                }
            }

            $img->name = ($data['name']) ?? '';
            $img->save();

            return response()->json('{"status": "ok"}');
        }
        catch (Exception $e){
            return response()->json('{"status": "false"}');
        }

    }
}
