<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{

    protected $fillable = ['drink_name', 'drink_description', 'servings', 'caffeine_amount'];

    protected $hidden = ['created_at', 'updated_at'];
//    protected $with = ['consumed'];
    //
    public function consumed()
    {
        return $this->hasMany('App\ConsumedDrink', 'drink_id', 'id');
    }
}
