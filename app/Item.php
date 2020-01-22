<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public function brands(){
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    public function categories(){
        return $this->belongsTo('App\Category', 'category_id');
    }
}
