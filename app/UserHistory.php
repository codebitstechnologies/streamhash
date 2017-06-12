<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    public function adminVideo() {
        return $this->belongsTo('App\adminVideo');
    }
}
