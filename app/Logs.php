<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    public function admin() {
        return $this->belongsTo('App\Admin', 'admin_id');
    }
}
