<?php

namespace App\Http\Controllers;

use App\Search;
use Illuminate\Http\Request;
use App\House;
use Auth;

class ListController extends Controller
{
    public function index(Request $request) {

        $data = $request->all();

        $search = [];

        $where = [];
        $orWhere = [];
        $orWhere2 = [];

        /**
         * prepare get request & array for json
         */
        if(!empty($data)) {

            if ($data['price_min']) {
                $where[] = ['price', '>=', (int)$data['price_min']];
                $search['min'] = $data['price_min'];
            }

            if ($data['price_max']) {
                $where[] = ['price', '<=', (int)$data['price_max']];
                $search['max'] = $data['price_max'];
            }

            if ($data['type'] > 0) {
                $where[] = ['house_type_id', '=', (int)$data['type']];
                $search['type'] = $data['type'];
            }

            if ($data['operation'] != '0') {
                $where[] = ['operation', '=', $data['operation']];
                $search['operation'] = $data['operation'];
            }

            if ($data['string']) {
                $tmp = $where;

                $where[] = ['name', 'like', '%' . $data['string'] . '%'];
                $orWhere = array_merge($tmp, [['address', 'like', '%' . $data['string'] . '%']]);
                $orWhere2 = array_merge($tmp, [['desc', 'like', '%' . $data['string'] . '%']]);
                $search['string'] = $data['string'];
            }
        }

        /**
         *  save search params to DB in json
         */
        if(Auth::check() && !empty($search)) {
            $json = json_encode($search);
            $searched = new Search();
            $searched->created_at = date(now());
            $searched->user_id = Auth::id();
            $searched->json = $json;
            $searched->save();
        }


        $houses = House::with(['image', 'watch', 'user'])->
        where($where)->orWhere($orWhere)->orWhere($orWhere2)->
        get()->toArray();

        return view('list')->with([
            'houses' => $houses,
            'types' => array_merge(['0' => 'All'], $this->types),
            'operation' => array_merge(['0' => 'All'], $this->operation),
            'rent' => $this->rent,
            'square' => $this->square
        ]);
    }

}
