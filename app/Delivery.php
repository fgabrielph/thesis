<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'order_id',
        'customer_name',
        'status',
        'ETA',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
