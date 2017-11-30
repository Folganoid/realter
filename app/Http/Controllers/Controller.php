<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\House_type;
use Illuminate\Support\Facades\Config;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $square;
    public $rent;
    public $types;
    public $operation;

    public function __construct()
    {
        $this->square = Config::get('settings.square_measure');
        $this->rent = Config::get('settings.rent_measure');
        $this->operation = Config::get('settings.operation');;
        $this->types = Config::get('settings.types');
    }
}
