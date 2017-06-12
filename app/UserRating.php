<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
    public function adminVideo() {
        return $this->belongsTo('App\adminVideo');
    }
}
