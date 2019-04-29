<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumedDrink extends Model
{
    public function drink()
    {
        return $this->belongsTo('App\Drink');
    }
}
