<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'house_id', 'created_at'
    ];

    protected $table = 'watch';
    //
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function house() {
        return $this->belongsTo('App\House');
    }
}
