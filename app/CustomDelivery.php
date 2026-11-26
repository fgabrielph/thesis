<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomDelivery extends Model
{
    protected $fillable = [
        'custom_order_id',
        'customer_name',
        'status',
        'ETA',
    ];

    public function custom_order()
    {
        return $this->belongsTo('App\CustomOrder', 'custom_order_id');
    }
}
