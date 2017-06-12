<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function subcategory() {
        return $this->belongsTo('App\SubCategory');
    }

    public function adminVideo()
    {
        return $this->hasMany('App\AdminVideo');
    }

    public static function boot()
    {
        //execute the parent's boot method 
        parent::boot();

        //delete your related models here, for example
        static::deleting(function($genres)
        {

            foreach($genres->adminVideo as $video)
            {                
                $video->delete();
            } 

        });	

    }
}
