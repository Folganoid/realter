<?php

namespace App\Http\Controllers;

use App\Search;
use Illuminate\Http\Request;
use App\House;
use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class ListController extends Controller
{
    public function index(Request $request) {

        $data = $request->except(['page']);;

        $search = [];
        $where = [];
        $orWhere = [];
        $orWhere2 = [];
        $sort = (isset($data['sort'])) ? explode('@', $data['sort']) : ['created_at' , 'DESC'];

        // price filter def
        $whereRaw = [0, INF];


        /**
         * prepare get request & array for json
         */

        if(!empty($data)) {

            if (isset($data['price_min']) && ($data['operation'] == '1')) {
                $whereRaw[0] = (int)$data['price_min'] / (int)$data['rent'];
                $search['min'] = $data['price_min'];
                $search['operation_measure_id'] = $data['rent'];
            }
            else if (isset($data['price_min'])) {
                $where[] = ['price', '>=', (int)$data['price_min']];
                $search['min'] = $data['price_min'];
            };

            if (isset($data['price_max']) && ($data['operation'] == '1')) {
                $whereRaw[1] = (int)$data['price_max'] / (int)$data['rent'];
                $search['max'] = $data['price_max'];
            }
            else if(isset($data['price_max']))
            {
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

            if (isset($data['string'])) {
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
        if(Auth::check() && !empty($search) && !isset($request->page)) {
            $json = json_encode($search);
            $searched = new Search();
            $searched->created_at = date(now());
            $searched->user_id = Auth::id();
            $searched->json = $json;
            $searched->save();
        }

        if($whereRaw[0] > 0 OR $whereRaw[1] !== INF) {
            $houses = House::with(['image', 'watch', 'user'])->
            where($where)->orWhere($orWhere)->orWhere($orWhere2)->
            whereRaw('price / operation_measure_id >= ?', [$whereRaw[0]])->
            whereRaw('price / operation_measure_id <= ?', [$whereRaw[1]])->
            orderBy($sort[0], $sort[1])->
            paginate($this->pagin);
        }
        else {
            $houses = House::with(['image', 'watch', 'user'])->
            where($where)->orWhere($orWhere)->orWhere($orWhere2)->
            orderBy($sort[0], $sort[1])->
            paginate($this->pagin);
        }

        return view('list')->with([
            'houses' => $houses->appends(Input::except('page')),
            'types' => (['0' => 'All'] + $this->types),
            'operation' => (['0' => 'All'] + $this->operation),
            'rent' => $this->rent,
            'square' => $this->square,
            'money' => $this->money,
        ]);
    }

}
