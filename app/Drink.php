<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    //
    public function consumed()
    {
        return $this->hasMany('App\ConsumedDrink');
    }
}
