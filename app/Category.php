<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public function subCategory()
    {
        return $this->hasMany('App\SubCategory');
    }

    public function genre()
    {
        return $this->hasMany('App\Genre');
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
        static::deleting(function($categories)
        {
            foreach($categories->subCategory as $sub_category)
            {  
                if($sub_category->picture1) {
                    Helper::delete_picture($sub_category->picture1, "/uploads/");
                }

                if($sub_category->picture2) {
                    Helper::delete_picture($sub_category->picture1, "/uploads/");
                }

                if($sub_category->picture3) {
                    Helper::delete_picture($sub_category->picture1, "/uploads/");
                }

                $sub_category->delete();
            } 

            foreach($categories->adminVideo as $video)
            {           
                deleteVideoAndImages($video);
                $video->delete();
            } 

            foreach($categories->genre as $genre)
            {                
                $genre->delete();
            } 

        });	

    }

    
}
