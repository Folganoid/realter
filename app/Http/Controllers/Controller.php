<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $square;
    public $rent;
    public $types;
    public $operation;
    public $money;

    public function __construct()
    {
        $this->square = Config::get('settings.square_measure');
        $this->rent = Config::get('settings.rent_measure');
        $this->operation = Config::get('settings.operation');
        $this->types = Config::get('settings.types');
        $this->money = Config::get('settings.money');

        \Cloudinary::config(array(
            "cloud_name" => "realtor222",
            "api_key" => "789844118893569",
            "api_secret" => "wb6o-wh12avO7yaR_02SfQuIa-k"
        ));
    }
}
