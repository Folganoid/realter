<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House_type extends Model
{
    public function house() {
        return $this->hasMany('App\House');
    }
}
