<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    protected $table = 'watch';
    //
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function house() {
        return $this->belongsTo('App\House');
    }
}
