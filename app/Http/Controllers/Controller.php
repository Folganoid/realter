<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\House_type;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * get house_types from db
     * @return array
     */
    protected function getHouseTypes()
    {
        $types = House_type::orderBy('name')->get()->toArray();
        $typesArr = [];

        for( $i = 0 ; $i < count($types); $i++) {
            $typesArr[$types[$i]['id']] = $types[$i]['name'];
        };

        return $typesArr;
    }
}
