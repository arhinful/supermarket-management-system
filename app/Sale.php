<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $guarded = [];

    public function item(){
        return $this->belongsTo('App\Item');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
