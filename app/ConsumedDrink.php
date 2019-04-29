<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumedDrink extends Model
{
//    protected $table = 'drinks-consumed';
//    protected $with = ['drink'];



    protected $fillable = ['drink_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function drink()
    {
        return $this->belongsTo('App\Drink', 'drink_id', 'id');
    }
}
