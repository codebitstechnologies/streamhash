<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class AdminVideo extends Model
{
	public function videoImage()
    {
        return $this->hasMany('App\AdminVideoImage');
    }

    public function userHistory()
    {
        return $this->hasMany('App\UserHistory');
    }

    public function userRating()
    {
        return $this->hasMany('App\UserRating');
    }

    public function userWishlist()
    {
        return $this->hasMany('App\Wishlist');
    }


    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function subCategory() {
        return $this->belongsTo('App\SubCategory');
    }

    public function genreName() {
        return $this->belongsTo('App\Genre');
    }

    /**
     * Get the flag record associated with the video.
     */
    public function userFlags()
    {
        return $this->hasMany('App\Flag', 'video_id', 'id');
    }

    /**
     * Get the pay per view record associated with the video.
     */
    public function userVideoSubscription()
    {
        return $this->hasMany('App\PayPerView', 'video_id', 'id');
    }

    public static function boot()
    {
        //execute the parent's boot method 
        parent::boot();

        //delete your related models here, for example
        static::deleting(function($video)
        {
            if (count($video->videoImage) > 0) {
                foreach($video->videoImage as $image)
                {
                    $image->delete();
                } 
            }

            if (count($video->userHistory) > 0) {
                foreach($video->userHistory as $history)
                {
                    $history->delete();
                } 
            }

            if (count($video->userRating) > 0) {
                foreach($video->userRating as $rating)
                {
                    $rating->delete();
                } 
            }

            if (count($video->userFlags) > 0) {
                foreach($video->userFlags as $flag)
                {
                    $flag->delete();
                } 
            }

            if (count($video->userVideoSubscription) > 0) {
                foreach($video->userVideoSubscription as $videoSubscription)
                {
                    $videoSubscription->delete();
                } 
            }

            if (count($video->userWishlist) > 0) {
                foreach($video->userWishlist as $wishlist)
                {
                    $wishlist->delete();
                } 
            }
        });	

    }

    /**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVideoResponse($query)
    {
        return $query->select(
            'admin_videos.id as admin_video_id' ,
            DB::raw('DATE_FORMAT(admin_videos.publish_time , "%e %b %y") as publish_time'),
            'admin_videos.watch_count' ,
            'admin_videos.duration',
            'admin_videos.ratings',
            'admin_videos.category_id',
            'categories.name as category_name',
            'admin_videos.title',
            'admin_videos.description',
            'admin_videos.default_image',
            'admin_videos.sub_category_id',
            'sub_categories.name as sub_category_name',
            'admin_videos.reviews',
            'admin_videos.created_at as video_date',
            'admin_videos.video',
            'admin_videos.trailer_video',
            'admin_videos.video_type',
            'admin_videos.video_upload_type',
            'admin_videos.amount',
            'admin_videos.type_of_user',
            'admin_videos.type_of_subscription',
            'admin_videos.category_id as category_id',
            'admin_videos.genre_id',
            'categories.is_series',
            'genres.name as genre_name',
            'admin_videos.is_approved',
            'admin_videos.status',
            'admin_videos.compress_status',
            'admin_videos.trailer_compress_status',
            'admin_videos.video_resolutions',
            'admin_videos.video_resize_path',
            'admin_videos.trailer_resize_path',
            'admin_videos.trailer_video_resolutions'
        );
    }
}
