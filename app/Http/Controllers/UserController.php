<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Helpers\Helper;

use App\Settings;

use App\User;

use App\Wishlist;

use App\Category;

use App\Page;

use App\Flag;

use Auth;

use Validator;

use Setting;

use Exception;

use App\PayPerView;

use Log;


class UserController extends Controller {

    protected $UserAPI;
    protected $Paypal;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $API)
    {
        $this->UserAPI = $API;
        
        $this->middleware('auth', ['except' => ['index','single_video','all_categories' ,'category_videos' , 'sub_category_videos' , 'contact','trending']]);
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $database = config('database.connections.mysql.database');
        
        $username = config('database.connections.mysql.username');

        if($database && $username && Setting::get('installation_process') == 3) {

            counter('home');

            $watch_lists = $wishlists = array();

            if(\Auth::check()){

                $wishlists  = Helper::wishlist(\Auth::user()->id,WEB);  

                $watch_lists = Helper::watch_list(\Auth::user()->id,WEB);  
            }
            
            $recent_videos = Helper::recently_added(WEB);

            $trendings = Helper::trending(WEB);
            
            $suggestions  = Helper::suggestion_videos(WEB);

            $categories = get_categories();

            return view('user.index')
                        ->with('page' , 'home')
                        ->with('subPage' , 'home')
                        ->with('wishlists' , $wishlists)
                        ->with('recent_videos' , $recent_videos)
                        ->with('trendings' , $trendings)
                        ->with('watch_lists' , $watch_lists)
                        ->with('suggestions' , $suggestions)
                        ->with('categories' , $categories);
        } else {
            return redirect()->route('installTheme');
        }
        
    }
//Added New function by Vishnu

    public function single_newvideo($id) {

        $video = Helper::get_video_details($id);

        $trendings = Helper::trending(WEB);

        $recent_videos = Helper::recently_added(WEB);

        $categories = get_categories();

        $comments = Helper::get_video_comments($id,0,WEB);

        $suggestions = Helper::suggestion_videos('', '', $id);

        $wishlist_status = $history_status = WISHLIST_EMPTY;

        $trailer_video = $main_video = "";

        $report_video = getReportVideoTypes();

        // Load the user flag

        $flaggedVideo = (Auth::check()) ? Flag::where('video_id',$id)->where('user_id', Auth::user()->id)->first() : '';

        if($video) {

            $trailer_video = $video->trailer_video;

            $main_video = $video->video; 

            if($video->video_type == 1) {

                if(check_valid_url($video->video) && $video->video_upload_type == 2) {
                    if(\Setting::get('streaming_url')) {
                        $main_video = \Setting::get('streaming_url').get_video_end($video->video);
                    }
                }

                if(check_valid_url($video->trailer_video) && $video->video_upload_type == 2) {
                    if(\Setting::get('streaming_url')) {
                        //$trailer_video = \Setting::get('streaming_url').get_video_end($video->trailer_video);
						$trailer_video = \Setting::get('streaming_url').get_video_end($video->video);
                    }
                }
            }


            $videoPath = $video_pixels = $trailer_video_path = $trailer_pixels = $trailerstreamUrl = $videoStreamUrl = '';
            if ($video->video_type == 1) {
                if (\Setting::get('streaming_url')) {
                    $trailerstreamUrl = \Setting::get('streaming_url').get_video_end($video->video);
                    $videoStreamUrl = \Setting::get('streaming_url').get_video_end($video->video);
                    if ($video->is_approved == 1) {
                        if($video->trailer_video_resolutions) {
                            $trailerstreamUrl = Helper::web_url().'/uploads/smil/'.get_video_end_smil($video->video).'.smil';
                        } 
                        if ($video->video_resolutions) {
                            $videoStreamUrl = Helper::web_url().'/uploads/smil/'.get_video_end_smil($video->video).'.smil';
                        }
                    }
                } else {

                    $videoPath = $video->video_resize_path ? $video->video.','.$video->video_resize_path : $video->video;
                    $video_pixels = $video->video_resolutions ? 'original,'.$video->video_resolutions : 'original';
                    $trailer_video_path = $video->trailer_video_path ? $video->trailer_video.','.$video->trailer_video_path : $video->trailer_video;
                    $trailer_pixels = $video->trailer_video_resolutions ? 'original'.$video->trailer_video_resolutions : 'original';

                }
            } else {
				
                //$trailerstreamUrl = $video->trailer_video;
				$trailerstreamUrl = $video->video;
                $videoStreamUrl = $video->video;
            }
            
        } else {
            return redirect('/')->with('flash_error' , tr('video_not_found'));
        }

        if(\Auth::check()) {
            $wishlist_status = Helper::check_wishlist_status(\Auth::user()->id,$id);
            $history_status = Helper::history_status(\Auth::user()->id,$id);

        }
        $share_link = route('user.single' , $id);
        
        return view('user.single_newvideo')
                    ->with('page' , '')
                    ->with('subPage' , '')
                    ->with('video' , $video)
                    ->with('recent_videos' , $recent_videos)
                    ->with('trendings' , $trendings)
                    ->with('comments' , $comments)
                    ->with('suggestions',$suggestions)
                    ->with('wishlist_status' , $wishlist_status)
                    ->with('history_status' , $history_status)
                    ->with('trailer_video' , $main_video)
                    ->with('main_video' , $main_video)
                    ->with('url' , $main_video)
                    ->with('categories' , $categories)
                    ->with('report_video', $report_video)
                    ->with('videoPath', $videoPath)
                    ->with('video_pixels', $video_pixels)
                    ->with('trailer_video_path', $trailer_video_path)
                    ->with('trailer_pixels', $trailer_pixels)
                    ->with('videoStreamUrl', $videoStreamUrl)
                    ->with('trailerstreamUrl', $videoStreamUrl)
                    ->with('flaggedVideo', $flaggedVideo);
    }

    /**
     * Show the profile list.
     *
     * @return \Illuminate\Http\Response
     */
	// End By Vishnu
	 
	public function single_video($id) {

        $video = Helper::get_video_details($id);

        $trendings = Helper::trending(WEB);

        $recent_videos = Helper::recently_added(WEB);

        $categories = get_categories();

        $comments = Helper::get_video_comments($id,0,WEB);

        $suggestions = Helper::suggestion_videos('', '', $id);

        $wishlist_status = $history_status = WISHLIST_EMPTY;

        $trailer_video = $main_video = "";

        $report_video = getReportVideoTypes();

        // Load the user flag

        $flaggedVideo = (Auth::check()) ? Flag::where('video_id',$id)->where('user_id', Auth::user()->id)->first() : '';

        if($video) {

            $trailer_video = $video->trailer_video;

            $main_video = $video->video; 

            if($video->video_type == 1) {

                if(check_valid_url($video->video) && $video->video_upload_type == 2) {
                    if(\Setting::get('streaming_url')) {
                        $main_video = \Setting::get('streaming_url').get_video_end($video->video);
                    }
                }

                if(check_valid_url($video->trailer_video) && $video->video_upload_type == 2) {
                    if(\Setting::get('streaming_url')) {
                        $trailer_video = \Setting::get('streaming_url').get_video_end($video->trailer_video);
                    }
                }
            }


            $videoPath = $video_pixels = $trailer_video_path = $trailer_pixels = $trailerstreamUrl = $videoStreamUrl = '';
            if ($video->video_type == 1) {
                if (\Setting::get('streaming_url')) {
                    $trailerstreamUrl = \Setting::get('streaming_url').get_video_end($video->trailer_video);
                    $videoStreamUrl = \Setting::get('streaming_url').get_video_end($video->video);
                    if ($video->is_approved == 1) {
                        if($video->trailer_video_resolutions) {
                            $trailerstreamUrl = Helper::web_url().'/uploads/smil/'.get_video_end_smil($video->trailer_video).'.smil';
                        } 
                        if ($video->video_resolutions) {
                            $videoStreamUrl = Helper::web_url().'/uploads/smil/'.get_video_end_smil($video->video).'.smil';
                        }
                    }
                } else {

                    $videoPath = $video->video_resize_path ? $video->video.','.$video->video_resize_path : $video->video;
                    $video_pixels = $video->video_resolutions ? 'original,'.$video->video_resolutions : 'original';
                    $trailer_video_path = $video->trailer_video_path ? $video->trailer_video.','.$video->trailer_video_path : $video->trailer_video;
                    $trailer_pixels = $video->trailer_video_resolutions ? 'original'.$video->trailer_video_resolutions : 'original';

                }
            } else {
                $trailerstreamUrl = $video->trailer_video;
                $videoStreamUrl = $video->video;
            }
            
        } else {
            return redirect('/')->with('flash_error' , tr('video_not_found'));
        }

        if(\Auth::check()) {
            $wishlist_status = Helper::check_wishlist_status(\Auth::user()->id,$id);
            $history_status = Helper::history_status(\Auth::user()->id,$id);

        }
        $share_link = route('user.single' , $id);
        
        return view('user.single-video')
                    ->with('page' , '')
                    ->with('subPage' , '')
                    ->with('video' , $video)
                    ->with('recent_videos' , $recent_videos)
                    ->with('trendings' , $trendings)
                    ->with('comments' , $comments)
                    ->with('suggestions',$suggestions)
                    ->with('wishlist_status' , $wishlist_status)
                    ->with('history_status' , $history_status)
                    ->with('trailer_video' , $trailer_video)
                    ->with('main_video' , $main_video)
                    ->with('url' , $main_video)
                    ->with('categories' , $categories)
                    ->with('report_video', $report_video)
                    ->with('videoPath', $videoPath)
                    ->with('video_pixels', $video_pixels)
                    ->with('trailer_video_path', $trailer_video_path)
                    ->with('trailer_pixels', $trailer_pixels)
                    ->with('videoStreamUrl', $videoStreamUrl)
                    ->with('trailerstreamUrl', $trailerstreamUrl)
                    ->with('flaggedVideo', $flaggedVideo);
    }

    /**
     * Show the profile list.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('user.profile')
                    ->with('page' , 'profile')
                    ->with('subPage' , 'user-profile');
    }

    /**
     * Show the profile list.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_profile()
    {
        return view('user.edit-profile')->with('page' , 'profile')
                    ->with('subPage' , 'user-update-profile');
    }

    /**
     * Save any changes to the users profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_save(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $response = $this->UserAPI->update_profile($request)->getData();

        if($response->success) {

            return back()->with('flash_success' , tr('profile_updated'));

        } else {

            $message = $response->error." ".$response->error_messages;
            return back()->with('flash_error' , $message);
        }
    }

    /**
     * Save changed password.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_save_password(Request $request)
    {
        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token,
        ]);

        $response = $this->UserAPI->change_password($request)->getData();

        if($response->success) {
            return back()->with('flash_success' , tr('password_success'));
        } else {
            $message = $response->error." ".$response->error_messages;
            return back()->with('flash_error' , $message);
        }

        return back()->with('response', $response);
    }

    public function profile_change_password(Request $request) {

        return view('user.change-password')->with('page' , 'profile')
                    ->with('subPage' , 'user-change-password');

    }

    public function add_history(Request $request) {

        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token
        ]);

        $response = $this->UserAPI->add_history($request)->getData();

        if($response->success) {
            $response->message = Helper::get_message(118);
        } else {
            $response->success = false;
            $response->message = "Something Went Wrong";
        }

        $response->status = $request->status;

        if ($request->video_status == 1) {

            // Load Payperview
            $payperview = PayPerView::where('user_id', \Auth::user()->id)->where('video_id',$request->admin_video_id)
                            ->where('status',0)->first();
            if ($payperview) {
                $payperview->status = DEFAULT_TRUE;
                $payperview->save();
            }
        }

        return response()->json($response);
    
    }

    public function delete_history(Request $request) {

        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token
        ]);

        $response = $this->UserAPI->delete_history($request)->getData();

        if($response->success) {
            return back()->with('flash_success' , Helper::get_message(121));

        } else {
            return back()->with('flash_error' , tr('admin_not_error'));
        }
    }

    public function history(Request $request) {

        $histories = Helper::watch_list(\Auth::user()->id,WEB);

        return view('user.history')
                        ->with('page' , 'profile')
                        ->with('subPage' , 'user-history')
                        ->with('histories' , $histories);
    }

    public function add_wishlist(Request $request) {

        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token
        ]);

        if($request->status == 1) {
            $response = $this->UserAPI->add_wishlist($request)->getData();
        } else {
            $response = $this->UserAPI->delete_wishlist($request)->getData();
        }

        if($response->success) {
            $response->message = Helper::get_message(118);
        } else {
            $response->success = false;
            $response->message = "Something Went Wrong";
        }

        $response->status = $request->status;

        return response()->json($response);
    }

    public function delete_wishlist(Request $request) {


        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token
        ]);

        $response = $this->UserAPI->delete_wishlist($request)->getData();

        if($response->success) {
            return back()->with('flash_success',tr('wishlist_removed'));
        } else {
            return back()->with('flash_error', "Something Went Wrong");
        }
    } 

    public function wishlist(Request $request) {
        
        $videos = Helper::wishlist(\Auth::user()->id,WEB);

        return view('user.wishlist')
                    ->with('page' , 'profile')
                    ->with('subPage' , 'user-wishlist')
                    ->with('videos' , $videos);
    }

    public function add_comment(Request $request) {

        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token
        ]);

        $response = $this->UserAPI->user_rating($request)->getData();

        if($response->success) {
            $response->message = Helper::get_message(118);
        } else {
            $response->success = false;
            $response->message = "Something Went Wrong";
        }

        return response()->json($response);
    
    }

    public function comments(Request $request) {

        $videos = Helper::get_user_comments(\Auth::user()->id,WEB);

        return view('user.comments')
                    ->with('page' , 'profile')
                    ->with('subPage' , 'user-comments')
                    ->with('videos' , $videos);
    }

    public function all_categories(Request $request) {

        $categories = get_categories();

        $recent_videos = Helper::recently_added(WEB);

        $trendings = Helper::trending(WEB);

        $suggestions = Helper::suggestion_videos(WEB);

        return view('user.all-categories')
                    ->with('page' , 'categories')
                    ->with('subPage' , 'categories')
                    ->with('categories' , $categories)
                    ->with('trendings' , $trendings)
                    ->with('suggestions' , $suggestions)
                    ->with('recent_videos' , $recent_videos);
    }


    public function category_videos($id) {

        $sub_categories = get_sub_categories($id);

        $videos = Helper::category_videos($id,WEB);

        $trendings = Helper::trending(WEB);

        $suggestions = Helper::suggestion_videos(WEB);

        $categories = get_categories();

        $category = Category::find($id);

        return view('user.category-videos')
                    ->with('page' , 'categories')
                    ->with('subPage' , 'categories')
                    ->with('category' , $category)
                    ->with('categories' , $categories)
                    ->with('sub_categories' , $sub_categories)
                    ->with('trendings' , $trendings)
                    ->with('suggestions' , $suggestions)
                    ->with('videos' , $videos);
    }

    public function sub_category_videos($id) {

        $videos = Helper::sub_category_videos($id,WEB);

        $trendings = Helper::trending(WEB);

        $suggestions = Helper::suggestion_videos(WEB);

        $sub_category = get_sub_category_details($id);

        $genres = get_genres($id);

        return view('user.sub_categories')
                    ->with('page' , 'categories')
                    ->with('subPage' , 'categories')
                    ->with('videos' , $videos)
                    ->with('trendings' , $trendings)
                    ->with('genres' , $genres)
                    ->with('sub_category' , $sub_category)
                    ->with('suggestions' , $suggestions);
    } 

    public function genre_videos($id) {

        $videos = Helper::genre_videos($id,WEB);

        $trendings = Helper::trending(WEB);

        $suggestions = Helper::suggestion_videos(WEB);

        $genre = get_genre_details($id);

        return view('user.genres')
                    ->with('page' , 'categories')
                    ->with('subPage' , 'categories')
                    ->with('videos' , $videos)
                    ->with('trendings' , $trendings)
                    ->with('genre' , $genre)
                    ->with('suggestions' , $suggestions);
    }

    public function contact(Request $request) {

        $contact = Page::where('type', 'contact')->first();

        return view('contact')->with('contact' , $contact)
                        ->with('page' , 'contact')
                        ->with('subPage' , '');

    }

    public function trending()
    {
        $trending = Helper::trending(1);
        $categories = get_categories();

        return view('user.trending')->with('page', 'trending')
                                    ->with('videos',$trending)
                                    ->with('categories', $categories);
    }

    public function delete_account(Request $request) {

        if(\Auth::user()->login_by == 'manual') {

            return view('user.delete-account')
                    ->with('page' , 'profile')
                    ->with('subPage' , 'delete-account');
        } else {

            $request->request->add([ 
                'id' => \Auth::user()->id,
                'token' => \Auth::user()->token,
                'device_token' => \Auth::user()->device_token
            ]);

            $response = $this->UserAPI->delete_account($request)->getData();

            if($response->success) {
                return back()->with('flash_success', tr('user_account_delete_success'));
            } else {
                if($response->error == 101)
                    return back()->with('flash_error', $response->error_messages);
                else
                    return back()->with('flash_error', $response->error);
            }

            return back()->with('flash_error', Helper::get_error_message(146));

        }
        
    }

    public function delete_account_process(Request $request) {

        $request->request->add([ 
            'id' => \Auth::user()->id,
            'token' => \Auth::user()->token,
            'device_token' => \Auth::user()->device_token
        ]);

        $response = $this->UserAPI->delete_account($request)->getData();

        if($response->success) {
            return back()->with('flash_success', tr('user_account_delete_success'));
        } else {
            if($response->error == 101)
                return back()->with('flash_error', $response->error_messages);
            else
                return back()->with('flash_error', $response->error);
        }

        return back()->with('flash_error', Helper::get_error_message(146));

    }

    /**
     * Function Name : save_report_videos
     * Save report videos based on user based
     *
     * @param object $request - Post Attributes
     *
     * @return flash message
     */
    public function save_report_video(Request $request) {
        try {
            // Validate the coming post values
            $validator = Validator::make($request->all(), [
                'video_id' => 'required',
                'reason' => 'required',
            ]);
            // If validator Fails, redirect same with error values
            if ($validator->fails()) {
                 //throw new Exception("error", tr('admin_published_video_failure'));
                return back()->with('flash_error', tr('admin_published_video_failure'));
            }
            // Assign Post request values into Data variable
            $data = $request->all();
            // include user_id index into the data varaible  "Auth::user()->id" -> Logged In user id
            $data['user_id'] = \Auth::user()->id;
            // Save the values in DB
            if ($report_video = Flag::create($data)) {
                return redirect('/')->with('flash_success', tr('report_video_success_msg'));
            } else {
                //throw new Exception("error", tr('admin_published_video_failure'));
                return back()->with('flash_error', tr('admin_published_video_failure'));
            }
        } catch (Exception $e) {
            return back()->with('flash_error', $e);
        }
    }

    /**
     * Function Name : remove_report_video()
     * Remove the video from spam folder and make it as unspam
     *
     * @param integer $id Flag id
     *
     * @return flash error/flash success
     */
    public function remove_report_video($id) {
        // Load Spam Video from flag section
        $model = Flag::where('id', $id)->first();
        Log::info("Loaded Values : ".print_r($model, true));
        // If the flag model exists then delete the row
        if ($model) {
            Log::info("Loaded Values 1 : ".print_r($model, true));
            Log::info("Delete values :". print_r($model->delete()));
            $model->delete();
            return back()->with('flash_success', tr('unmark_report_video_success_msg'));
        } else {
            // throw new Exception("error", tr('admin_published_video_failure'));
            return back()->with('flash_error', tr('admin_published_video_failure'));
        }
    }

    /**
     * Function Name : spam_videos()
     * Based on logged in user load spam videos
     *
     * @return spam videos
     */
    public function spam_videos() {
        // Get logged in user id
        $id = Auth::user()->id;
        $model = Flag::where('user_id', $id)
            ->leftJoin('admin_videos' , 'flags.video_id' , '=' , 'admin_videos.id')
            ->leftJoin('categories' , 'admin_videos.category_id' , '=' , 'categories.id')
            ->leftJoin('sub_categories' , 'admin_videos.sub_category_id' , '=' , 'sub_categories.id')
            ->select('flags.*','admin_videos.is_approved', 'admin_videos.status')
            ->where('admin_videos.is_approved' , 1)
            ->where('admin_videos.status' , 1)
            ->paginate(16);
        // Return array of values
        return view('user.spam_videos')->with('model' , $model)
                        ->with('page' , 'Profile')
                        ->with('subPage' , 'Spam Videos');
    }   

    /**
     * Function Name: payper_videos()
     * To load all the paper views
     *
     * @return view page
     */
    public function payper_videos() {
        // Get Logged in user id
        $id = Auth::user()->id;
        // Load all the paper view videos based on logged in user id
        $model = PayPerView::where('user_id', $id)->paginate(16);
        // Return the view page
        return view('user.payperview')->with('model' , $model)
                        ->with('page' , 'Profile')
                        ->with('subPage' , 'Payper Videos');
    }
}