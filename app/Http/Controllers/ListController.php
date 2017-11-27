<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;

class ListController extends Controller
{
    public function index(Request $request) {

        $data = $request->all();

        $where = [];
        $orWhere = [];
        $orWhere2 = [];

        if(!empty($data)) {

            if ($data['price_min']) {
                $where[] = ['price', '>=', (int)$data['price_min']];
            }

            if ($data['price_max']) {
                $where[] = ['price', '<=', (int)$data['price_max']];
            }

            if ($data['type'] > 0) {
                $where[] = ['house_type_id', '=', (int)$data['type']];
            }

            if ($data['operation'] != '0') {
                $where[] = ['operation', '=', $data['operation']];
            }

            if ($data['string']) {
                $tmp = $where;

                $where[] = ['name', 'like', '%' . $data['string'] . '%'];
                $orWhere = array_merge($tmp, [['address', 'like', '%' . $data['string'] . '%']]);
                $orWhere2 = array_merge($tmp, [['desc', 'like', '%' . $data['string'] . '%']]);
            }
        }

        $houses = House::with(['image', 'document', 'houseType', 'watch', 'user'])->
        where($where)->orWhere($orWhere)->orWhere($orWhere2)->
        get()->toArray();

        return view('list')->with(['houses' => $houses, 'types' => array_merge(['0' => 'All'], $this->getHouseTypes())]);
    }

}
