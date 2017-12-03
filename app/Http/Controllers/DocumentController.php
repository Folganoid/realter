<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use App\House;
use Auth;
use Gate;
use League\Flysystem\Exception;


class DocumentController extends Controller
{
    /**
     * delete doc from cloud & DB
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {

        try {
            $doc = Document::find($id);
            $house = House::find($doc->house_id);


            if ($house->user_id != Auth::id()) {
                if (Gate::denies('is-admin')) {
                    return response()->json('{"status": "false"}');
                }
            }

            \Cloudinary\Uploader::destroy(substr($doc->path, 0, strrpos($doc->path, '.')));
            $doc->delete();
            return response()->json('{"status": "ok"}');
        }
        catch (Exception $e){
            return response()->json('{"status": "false"}');
        }
    }

    /**
     * update doc name
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request) {

        try {
            $data = $request->all();
            $doc = Document::find($data['id']);

            $house = House::find($doc->house_id);

            if ($house->user_id != Auth::id()) {
                if (Gate::denies('is-admin')) {
                    return response()->json('{"status": "false"}');
                }
            }

            $doc->name = ($data['name']) ?? '';
            $doc->save();

            return response()->json('{"status": "ok"}');
        }
        catch (Exception $e){
            return response()->json('{"status": "false"}');
        }

    }
}
