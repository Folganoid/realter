<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{

    protected $fillable = [
        'name', 'user_id', 'desc', 'price', 'square', 'address', 'operation', 'house_type_id', 'openview', 'openview_min',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function houseType() {
        return $this->belongsTo('App\House_type');
    }

    public function image() {
        return $this->hasMany('App\Image');
    }

    public function document() {
        return $this->hasMany('App\Document');
    }

    public function watch() {
        return $this->hasMany('App\Watch');
    }

}
