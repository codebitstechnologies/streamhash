<?php 

   namespace App\Helpers;

    use Hash;

    use App\Admin;

    use App\User;

    use App\AdminVideo;

    use App\AdminVideoImage;

    use App\Category;

    use App\SubCategory;

    use App\SubCategoryImage;

    use App\Wishlist;

    use App\UserHistory;

    use App\UserRating;

    use App\UserPayment;

    use Auth;

    use AWS;

    use App\Requests;

    use Mail;

    use File;

    use Log;

    use Storage;

    use Setting;

    use DB;

    use App\Jobs\OriginalVideoCompression;


    class Helper
    {
        public static function clean($string)
        {
            $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }

        public static function web_url()
        {
            return url('/');
        }

        // Note: $error is passed by reference
        public static function is_token_valid($entity, $id, $token, &$error)
        {
            if (
                ( $entity== 'USER' && ($row = User::where('id', '=', $id)->where('token', '=', $token)->first()) ) ||
                ( $entity== 'PROVIDER' && ($row = Provider::where('id', '=', $id)->where('token', '=', $token)->first()) )
            ) {
                if ($row->token_expiry > time()) {
                    // Token is valid
                    $error = NULL;
                    return $row;
                } else {
                    $error = array('success' => false, 'error' => Helper::get_error_message(103), 'error_code' => 103);
                    return FALSE;
                }
            }
            $error = array('success' => false, 'error' => Helper::get_error_message(104), 'error_code' => 104);
            return FALSE;
        }

        // Convert all NULL values to empty strings
        public static function null_safe($arr)
        {
            $newArr = array();
            foreach ($arr as $key => $value) {
                $newArr[$key] = ($value == NULL) ? "" : $value;
            }
            return $newArr;
        }

        public static function generate_token()
        {
            return Helper::clean(Hash::make(rand() . time() . rand()));
        }

        public static function generate_token_expiry()
        {
            return time() + 24*3600*30;  // 30 days
        }

        public static function send_email($page,$subject,$email,$email_data)
        {
            \Log::info(env('MAIL_USERNAME'));

            \Log::info(env('MAIL_PASSWORD'));

            if( config('mail.username') &&  config('mail.password')) {
                try {

                    $site_url=url('/');
                    Mail::queue($page, array('email_data' => $email_data,'site_url' => $site_url), function ($message) use ($email, $subject) {

                            $message->to($email)->subject($subject);
                    });
                } catch(Exception $e) {
                    \Log::info($e);
                    return Helper::get_error_message(123);
                }
                return Helper::get_message(105);

            } else {
                return Helper::get_error_message(123);
            }
        }

        public static function get_error_message($code)
        {
            switch($code) {
                case 101:
                    $string = "Invalid input.";
                    break;
                case 102:
                    $string = "Email address is already in use.";
                    break;
                case 103:
                    $string = "Token expired.";
                    break;
                case 104:
                    $string = "Invalid token.";
                    break;
                case 105:
                    $string = "Invalid email or password.";
                    break;
                case 106:
                    $string = "All fields are required.";
                    break;
                case 107:
                    $string = "The current password is incorrect.";
                    break;
                case 108:
                    $string = "The passwords do not match.";
                    break;
                case 109:
                    $string = "There was a problem with the server. Please try again.";
                    break;
                case 111:
                    $string = "Email is not activated.";
                    break;
                case 115:
                    $string = "Invalid refresh token.";
                    break;
                case 123:
                    $string = "Something went wrong in mail configuration";
                    break;
                case 124:
                    $string = "This Email is not registered";
                    break;
                case 125:
                    $string = "Not a valid social registration User";
                    break;
                case 130:
                    $string = "No results found";
                    break;
                case 131:
                    $string = 'Password doesn\'t match';
                    break;
                case 132:
                    $string = 'Provider ID not found';
                    break;
                case 133:
                    $string = 'User ID not found';
                    break;
                case 141:
                    $string = "Something went wrong while paying amount.";
                    break;
                case 144:
                    $string = "Account is disabled by admin";
                    break;
                case 145:
                    $string = "The video is already added in history.";
                    break;
                case 146:
                    $string = "Something went Wrong.Please try again later!.";
                    break;

                default:
                    $string = "Unknown error occurred.";
            }
            return $string;
        }

        public static function get_message($code)
        {
            switch($code) {
                case 101:
                    $string = "Success";
                    break;
                case 102:
                    $string = "Password Changed successfully.";
                    break;
                case 103:
                    $string = "Successfully logged in.";
                    break;
                case 104:
                    $string = "Successfully logged out.";
                    break;
                case 105:
                    $string = "Successfully signed up.";
                    break;
                case 106:
                    $string = "Mail sent successfully";
                    break;
                case 107:
                    $string = "Payment successfully done";
                    break;
                case 108:
                    $string = "Favourite provider deleted successfully";
                    break;
                case 109:
                    $string = "Payment mode changed successfully";
                    break;
                case 110:
                    $string = "Payment mode changed successfully";
                    break;
                case 111:
                    $string = "Service Accepted";
                    break;
                case 112:
                    $string = "provider started";
                    break;
                case 113:
                    $string = "Arrived to service location";
                    break;
                case 114:
                    $string = "Service started";
                    break;
                case 115:
                    $string = "Service completed";
                    break;
                case 116:
                    $string = "User rating done";
                    break;
                case 117:
                    $string = "Request cancelled successfully.";
                    break;
                case 118:
                    $string = "Wishlist added.";
                    break;
                case 119:
                    $string = "Payment confirmed successfully.";
                    break;
                case 120:
                    $string = "History added.";
                    break;
                case 121:
                    $string = "History deleted Successfully.";
                    break;
                default:
                    $string = "";
            }
            return $string;
        }

        public static function get_push_message($code) {

            switch ($code) {
                case 601:
                    $string = "No Provider Available";
                    break;
                case 602:
                    $string = "No provider available to take the Service.";
                    break;
                case 603:
                    $string = "Request completed successfully";
                    break;
                case 604:
                    $string = "New Request";
                    break;
                default:
                    $string = "";
            }

            return $string;

        }

        public static function generate_password()
        {
            $new_password = time();
            $new_password .= rand();
            $new_password = sha1($new_password);
            $new_password = substr($new_password,0,8);
            return $new_password;
        }

        public static function upload_video_image($image,$video_id,$position) {

            $check_video_image = AdminVideoImage::where('admin_video_id' , $video_id)->where('position',$position)->first();

            if($check_video_image) {
                $video_image = $check_video_image;

                Helper::delete_picture($video_image->image, "/uploads/");

            } else {
                $video_image = new AdminVideoImage;
            }

            $video_image->admin_video_id = $video_id;
            $video_image->image = Helper::normal_upload_picture($image);

            if($position == 1) {
                $video_image->is_default = DEFAULT_TRUE;
            } else {
                $video_image->is_default = DEFAULT_FALSE;
            }

            $video_image->position = $position;

            $video_image->save();
            Log::info('VIDEO IMAGE SAVED : '.$video_image->id);

        }

        public static function upload_picture($picture)
        {
            Helper::delete_picture($picture, "/uploads/");

            $s3_url = "";

            $file_name = Helper::file_name();

            $ext = $picture->getClientOriginalExtension();
            $local_url = $file_name . "." . $ext;

            if(config('filesystems')['disks']['s3']['key'] && config('filesystems')['disks']['s3']['secret']) {

                Storage::disk('s3')->put($local_url, file_get_contents($picture) ,'public');

                $s3_url = Storage::url($local_url);
            } else {
                $ext = $picture->getClientOriginalExtension();
                $picture->move(base_path() . "/uploads", $file_name . "." . $ext);
                $local_url = $file_name . "." . $ext;

                $s3_url = Helper::web_url().'/uploads/'.$local_url;
            }

            return $s3_url;
        }

        public static function normal_upload_picture($picture)
        {
            $s3_url = "";

            $file_name = Helper::file_name();

            $ext = $picture->getClientOriginalExtension();

            $local_url = $file_name . "." . $ext;

            $path = '/uploads/images/';

            $inputFile = base_path('public'.$path.$local_url);

            // Convert bytes into MB
            $bytes = convertMegaBytes($picture->getClientSize());

            if ($bytes > Setting::get('image_compress_size')) {

                // Compress the video and save in original folder
                $FFmpeg = new \FFmpeg;

                $FFmpeg
                    ->input($picture->getPathname())
                    ->output($inputFile)
                    ->ready();
                // dd($FFmpeg->command);
            } else {

                $picture->move(base_path() . "/uploads/images/", $local_url);

            }

            $s3_url = Helper::web_url().'/uploads/images/'.$local_url;

            return $s3_url;
        }

        public static function video_upload($picture, $compress_type)
        {
            
            $s3_url = "";

            $file_name = Helper::file_name();

            $ext = $picture->getClientOriginalExtension();

            $local_url = $file_name . "." . $ext;

            $path = '/uploads/videos/original/';

            // Convert bytes into MB
            $bytes = convertMegaBytes($picture->getClientSize());

            $inputFile = base_path('public'.$path.$local_url);

            if ($bytes > Setting::get('video_compress_size') && $compress_type == DEFAULT_TRUE) {

                // dispatch(new OriginalVideoCompression($picture->getPathname(), $inputFile));

                Log::info("Compress Video : ".'Success');

                // Compress the video and save in original folder
                $FFmpeg = new \FFmpeg;

                $FFmpeg
                    ->input($picture->getPathname())
                    ->vcodec('h264')
                    ->constantRateFactor('28')
                    ->output($inputFile)
                    ->ready();

            } else {
                Log::info("Original Video");
                $picture->move(base_path() . $path, $local_url);
            }

            $s3_url = Helper::web_url().$path.$local_url;

            Log::info("Compress Video completed");

            return ['db_url'=>$s3_url, 'baseUrl'=> $inputFile, 'local_url'=>$local_url, 'file_name'=>$file_name];
        }

        public static function delete_picture($picture, $path) {
            // "/uploads/"
            File::delete( base_path() . $path . basename($picture));
            return true;
        }

        public static function s3_delete_picture($picture) {
            Log::info($picture);

            Storage::Delete(basename($picture));
            return true;
        }

        public static function file_name() {

            $file_name = time();
            $file_name .= rand();
            $file_name = sha1($file_name);

            return $file_name;
        }

        public static function recently_added($web = NULL , $skip = 0) {

            $videos_query = AdminVideo::where('admin_videos.is_approved' , 1)
                            ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
                            ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
                            ->leftJoin('genres' , 'admin_videos.genre_id' , '=' , 'genres.id')
                            ->where('admin_videos.status' , 1)
                            ->videoResponse()
                            ->orderby('admin_videos.created_at' , 'desc');
            if (Auth::check()) {
                // Check any flagged videos are present
                $flagVideos = getFlagVideos(Auth::user()->id);

                if($flagVideos) {
                    $videos_query->whereNotIn('admin_videos.id',$flagVideos);
                }
            }

            if($web) {
                $videos = $videos_query->paginate(16);

            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))
                            ->get();
            }

            return $videos;
        }

        public static function wishlist($user_id, $web = NULL , $skip = 0) {

            $videos_query = Wishlist::where('user_id' , $user_id)
                            ->leftJoin('admin_videos' ,'wishlists.admin_video_id' , '=' , 'admin_videos.id')
                            ->leftJoin('categories' ,'admin_videos.category_id' , '=' , 'categories.id')
                            ->where('admin_videos.is_approved' , 1)
                            ->where('admin_videos.status' , 1)
                            ->where('wishlists.status' , 1)
                            ->select(
                                    'wishlists.id as wishlist_id','admin_videos.id as admin_video_id' ,
                                    'admin_videos.title','admin_videos.description' ,
                                    'default_image','admin_videos.watch_count','admin_videos.ratings',
                                    'admin_videos.duration','admin_videos.category_id',
                                    DB::raw('DATE_FORMAT(admin_videos.publish_time , "%e %b %y") as publish_time') , 'categories.name as category_name')
                            ->orderby('wishlists.created_at' , 'desc');

            // Check any flagged videos are present
            $flagVideos = getFlagVideos($user_id);
            if($flagVideos) {
                $videos_query->whereNotIn('admin_video_id', $flagVideos);
            }

            if($web) {
                $videos = $videos_query->paginate(16);

            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))
                            ->get();
            }

            return $videos;

        }

        public static function watch_list($user_id, $web = NULL , $skip = 0) {

            $videos_query = UserHistory::where('user_id' , $user_id)
                            ->leftJoin('admin_videos' ,'user_histories.admin_video_id' , '=' , 'admin_videos.id')
                            ->leftJoin('categories' ,'admin_videos.category_id' , '=' , 'categories.id')
                            ->where('admin_videos.is_approved' , 1)
                            ->where('admin_videos.status' , 1)
                            ->select('user_histories.id as history_id','admin_videos.id as admin_video_id' ,
                                'admin_videos.title','admin_videos.description' , 'admin_videos.duration',
                                'default_image','admin_videos.watch_count','admin_videos.ratings',
                                DB::raw('DATE_FORMAT(admin_videos.publish_time , "%e %b %y") as publish_time'), 'admin_videos.category_id','categories.name as category_name')
                            ->orderby('user_histories.created_at' , 'desc');
            // Check any flagged videos are present
            $flagVideos = getFlagVideos($user_id);

            if($flagVideos) {
                $videos_query->whereNotIn('admin_videos.id', $flagVideos);
            }

            if($web) {
                $videos = $videos_query->paginate(16);

            } else {

                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))->get();
            }

            return $videos;

        }

        public static function banner_videos() {

            $videos = AdminVideo::where('admin_videos.is_approved' , 1)
                            ->where('admin_videos.status' , 1)
                            ->where('admin_videos.is_banner' , 1)
                            ->select(
                                'admin_videos.id as admin_video_id' ,
                                'admin_videos.title','admin_videos.ratings',
                                'admin_videos.banner_image as default_image'
                                )
                            ->orderBy('created_at' , 'desc')
                            ->get();

            return $videos;
        }

        public static function suggestion_videos($web = NULL , $skip = 0, $id = null) {

            $videos_query = AdminVideo::where('admin_videos.is_approved' , 1)
                            ->where('admin_videos.status' , 1)
                            ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
                            ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
                            ->leftJoin('genres' , 'admin_videos.genre_id' , '=' , 'genres.id')
                            ->videoResponse()
                            ->orderByRaw('RAND()');
            if (Auth::check()) {
                // Check any flagged videos are present
                $flagVideos = getFlagVideos(Auth::user()->id);

                if($flagVideos) {
                    $videos_query->whereNotIn('admin_videos.id',$flagVideos);
                }
            }

            if ($id) {
                $videos_query->where('admin_videos.id', '!=', $id);
            }
            if($web) {
                $videos = $videos_query->paginate(16);

            } else {

                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))
                            ->get();
            }

            return $videos;

        }

        public static function trending($web = NULL , $skip = 0) {

            $videos_query = AdminVideo::where('watch_count' , '>' , 0)
                            ->where('admin_videos.is_approved' , 1)
                            ->where('admin_videos.status' , 1)
                            ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
                            ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
                            ->leftJoin('genres' , 'admin_videos.genre_id' , '=' , 'genres.id')
                            ->videoResponse()
                            ->orderby('watch_count' , 'desc');
            if (Auth::check()) {
                // Check any flagged videos are present
                $flagVideos = getFlagVideos(Auth::user()->id);

                if($flagVideos) {
                    $videos_query->whereNotIn('admin_videos.id', $flagVideos);
                }
            }

            if($web) {
                $videos = $videos_query->paginate(16);
            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))->get();
            }

            return $videos;

        }

        public static function category_videos($category_id, $web = NULL , $skip = 0) {

            $videos_query = AdminVideo::where('admin_videos.is_approved' , 1)
                        ->where('admin_videos.status' , 1)
                        ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
                        ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
                        ->leftJoin('genres' , 'admin_videos.genre_id' , '=' , 'genres.id')
                        ->where('admin_videos.category_id' , $category_id)
                        ->videoResponse()
                        ->orderby('admin_videos.sub_category_id' , 'asc');
            if (Auth::check()) {
                // Check any flagged videos are present
                $flagVideos = getFlagVideos(Auth::user()->id);

                if($flagVideos) {
                    $videos_query->whereNotIn('admin_videos.id', $flagVideos);
                }
            }

            if($web) {
                $videos = $videos_query->paginate(16);
            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))->get();
            }

            return $videos;
        }

        public static function sub_category_videos($sub_category_id , $web = NULL , $skip = 0) {

            $videos_query = AdminVideo::where('admin_videos.is_approved' , 1)
                        ->where('admin_videos.status' , 1)
                        ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
                        ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
                        ->leftJoin('genres' , 'admin_videos.genre_id' , '=' , 'genres.id')
                        ->where('admin_videos.sub_category_id' , $sub_category_id)
                        ->videoResponse()
                        ->orderby('admin_videos.sub_category_id' , 'asc');
            if (Auth::check()) {
                // Check any flagged videos are present
                $flagVideos = getFlagVideos(Auth::user()->id);

                if($flagVideos) {
                    $videos_query->whereNotIn('admin_videos.id', $flagVideos);
                }
            }
            
            if($web) {
                $videos = $videos_query->paginate(16);
            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))->get();
            }

            return $videos;
        }

        public static function genre_videos($id , $web = NULL , $skip = 0) {

            $videos_query = AdminVideo::where('admin_videos.is_approved' , 1)
                        ->where('admin_videos.status' , 1)
                        ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
                        ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
                        ->leftJoin('genres' , 'admin_videos.genre_id' , '=' , 'genres.id')
                        ->where('admin_videos.genre_id' , $id)
                        ->videoResponse()
                        ->orderby('admin_videos.sub_category_id' , 'asc');

            if($web) {
                $videos = $videos_query->paginate(16);
            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))->get();
            }

            return $videos;
        }

        public static function get_video_details($video_id) {

            $videos = AdminVideo::where('admin_videos.id' , $video_id)
                    ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
                    ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
                    ->leftJoin('genres' , 'admin_videos.genre_id' , '=' , 'genres.id')
                    ->videoResponse()
                    ->orderBy('admin_videos.created_at' , 'desc')
                    ->first();

            if(!$videos) {
                $videos = array();
            }

            return $videos;
        }

        public static function video_ratings($video_id) {

            $ratings = UserRating::where('admin_video_id' , $video_id)
                            ->leftJoin('users' , 'user_ratings.user_id' , '=' , 'users.id')
                            ->select('users.id as user_id' , 'users.name as username',
                                    'users.picture as user_picture' ,

                                    'user_ratings.rating' , 'user_ratings.comment',
                                    'user_ratings.created_at')
                            ->get();
            if(!$ratings) {
                $ratings = array();
            }

            return $ratings;
        }

        public static function wishlist_status($video_id,$user_id) {
            if($wishlist = Wishlist::where('admin_video_id' , $video_id)->where('user_id' , $user_id)->first()) {
                if($wishlist->status)
                    return 1;
                else
                    return 0 ;
            } else {
                return 0;
            }
        }

        public static function history_status($video_id,$user_id) {
            if(UserHistory::where('admin_video_id' , $video_id)->where('user_id' , $user_id)->count()) {
                return 1;
            } else {
                return 0;
            }
        }

        public static function search_video($key,$web = NULL,$skip = 0) {

            $videos_query = AdminVideo::where('admin_videos.is_approved' ,'=', 1)
                        ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
                        ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
                        ->leftJoin('genres' , 'admin_videos.genre_id' , '=' , 'genres.id')
                        ->where('title','like', '%'.$key.'%')
                        ->where('admin_videos.status' , 1)
                        ->videoResponse()
                        ->orderBy('admin_videos.created_at' , 'desc');


            if($web) {
                $videos = $videos_query->paginate(16);
            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))->get();
            }

            return $videos;
        }

        public static function get_user_comments($user_id,$web = NULL) {

            $videos_query = UserRating::where('user_id' , $user_id)
                            ->leftJoin('admin_videos' ,'user_ratings.admin_video_id' , '=' , 'admin_videos.id')
                            ->where('admin_videos.is_approved' , 1)
                            ->where('admin_videos.status' , 1)
                            ->select('admin_videos.id as admin_video_id' ,
                                'admin_videos.title','admin_videos.description' ,
                                'default_image','admin_videos.watch_count',
                                'admin_videos.duration',
                                DB::raw('DATE_FORMAT(admin_videos.publish_time , "%e %b %y") as publish_time'))
                            ->orderby('user_ratings.created_at' , 'desc')
                            ->groupBy('admin_videos.id');

            if($web) {
                $videos = $videos_query->paginate(16);
            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' ,12))->get();
            }

            return $videos;

        }

        public static function get_video_comments($video_id,$skip = 0 ,$web = NULL) {

            $videos_query = UserRating::where('admin_video_id' , $video_id)
                            ->leftJoin('admin_videos' ,'user_ratings.admin_video_id' , '=' , 'admin_videos.id')
                            ->leftJoin('users' ,'user_ratings.user_id' , '=' , 'users.id')
                            ->where('admin_videos.is_approved' , 1)
                            ->where('admin_videos.status' , 1)
                            ->select('admin_videos.id as admin_video_id' ,
                                'user_ratings.user_id as rating_user_id' ,
                                'user_ratings.rating as rating',
                                'user_ratings.comment', 'user_ratings.created_at',
                                'users.name as username' , 'users.picture')
                            ->orderby('user_ratings.created_at' , 'desc');
            if($web) {
                $videos = $videos_query->get();
            } else {
                $videos = $videos_query->skip($skip)->take(Setting::get('admin_take_count' , 12));
            }

            return $videos;

        }

        public static function check_wishlist_status($user_id,$video_id) {

            $status = Wishlist::where('user_id' , $user_id)
                                        ->where('admin_video_id' , $video_id)
                                        ->where('status' , 1)
                                        ->first();
            return $status;
        }

        public static function send_notification($id,$title,$message) {

            Log::info("Send Push Started");

            // Check the user type whether "USER" or "PROVIDER"
            if($id == "all") {
                $users = User::where('push_status' , 1)->get();
            } else {
                $users = User::find($id);
            }

            $push_data = array();

            $push_message = array('success' => true,'message' => $message,'data' => array());

            $push_notification = 1; // Check the push notifictaion is enabled

            if ($push_notification == 1) {

                Log::info('Admin enabled the push ');

                if($users){

                    Log::info('Check users variable');

                    foreach ($users as $key => $user) {

                        Log::info('Individual User');

                        if ($user->device_type == 'ios') {

                            Log::info("iOS push Started");

                            require_once app_path().'/ios/apns.php';

                            $msg = array("alert" => $message,
                                "status" => "success",
                                "title" => $title,
                                "message" => $push_message,
                                "badge" => 1,
                                "sound" => "default",
                                "status" => "",
                                "rid" => "",
                                );

                            if (!isset($user->device_token) || empty($user->device_token)) {
                                $deviceTokens = array();
                            } else {
                                $deviceTokens = $user->device_token;
                            }

                            $apns = new \Apns();
                            $apns->send_notification($deviceTokens, $msg);

                            Log::info("iOS push end");

                        } else {

                            Log::info("Andriod push Started");

                            require_once app_path().'/gcm/GCM_1.php';
                            require_once app_path().'/gcm/const.php';

                            if (!isset($user->device_token) || empty($user->device_token)) {
                                $registatoin_ids = "0";
                            } else {
                                $registatoin_ids = trim($user->device_token);
                            }
                            if (!isset($push_message) || empty($push_message)) {
                                $msg = "Message not set";
                            } else {
                                $msg = $push_message;
                            }
                            if (!isset($title) || empty($title)) {
                                $title1 = "Message not set";
                            } else {
                                $title1 = trim($title);
                            }

                            $message = array(TEAM => $title1, MESSAGE => $msg);

                            $gcm = new \GCM();
                            $registatoin_ids = array($registatoin_ids);
                            $gcm->send_notification($registatoin_ids, $message);

                            Log::info("Andriod push end");

                        }

                    }

                }

            } else {
                Log::info('Push notifictaion is not enabled. Please contact admin');
            }

            Log::info("*************************************");

        }
    }
