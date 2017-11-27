<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    //
    public $timestamps = false;
    protected $table = 'search';

    protected $fillable = [
        'user_id', 'json', 'created_at'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
