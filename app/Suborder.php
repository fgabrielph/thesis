<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suborder extends Model
{
    protected $fillable = [
        'id', 'item_id', 'order_id', 'price', 'quantity', 'created_at', 'updated_at'
    ];

    public function order() {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
