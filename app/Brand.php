<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function items(){
        return $this->hasMany('App\Items', 'brand_id');
    }
}
