<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $guarded = [];

    public function cart(){
        return $this->hasOne('App\Cart');
    }

    public function sales(){
        return $this->hasMany('App\Sale');
    }

}
