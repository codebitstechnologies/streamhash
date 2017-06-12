<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
	public function subCategoryImage()
    {
        return $this->hasMany('App\SubCategoryImage');
    }

    public function genres()
    {
        return $this->hasMany('App\Genre');
    }

    public function adminVideo()
    {
        return $this->hasMany('App\AdminVideo');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public static function boot()
    {
        //execute the parent's boot method 
        parent::boot();

        //delete your related models here, for example
        static::deleting(function($sub_categories)
        {
        	foreach($sub_categories->subCategoryImage as $image)
            {
                $image->delete();
            } 

            foreach($sub_categories->genres as $genre)
            {                
                $genre->delete();
            } 

            foreach($sub_categories->adminVideo as $video)
            {                
                deleteVideoAndImages($video);
                $video->delete();
            } 

        });	

    }
    
}
