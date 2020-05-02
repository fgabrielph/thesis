<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomDelivery extends Model
{
    public function custom_order() {
        return $this->belongsTo('App\CustomOrder', 'custom_order_id');
    }

}
