<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;

    //
    public function house() {
        return $this->belongsTo('App\Houses');
    }

}
