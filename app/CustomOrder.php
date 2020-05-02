<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function custom_delivery() {
        return $this->hasMany(CustomDelivery::class);
    }
}
