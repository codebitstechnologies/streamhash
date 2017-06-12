<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    public function adminVideo() {
        return $this->belongsTo('App\AdminVideo');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
