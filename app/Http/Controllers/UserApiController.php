<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use Log;

use Hash;

use Validator;

use File;

use DB;

use Setting;

use App\User;

use App\Admin;

use App\AdminVideo;

use App\AdminVideoImage;

use App\Settings;

use App\UserRating;

use App\Wishlist;

use App\UserHistory;

use App\Page;

use App\Jobs\NormalPushNotification;

class UserApiController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('UserApiVal' , array('except' => ['register' , 'login' , 'forgot_password','search_video' , 'privacy','about' , 'terms','contact']));

    }
    public function register(Request $request)
    {
        $response_array = array();
        $operation = false;
        $new_user = DEFAULT_TRUE;

        // validate basic field

        $basicValidator = Validator::make(
            $request->all(),
            array(
                'device_type' => 'required|in:'.DEVICE_ANDROID.','.DEVICE_IOS,
                'device_token' => 'required',
                'login_by' => 'required|in:manual,facebook,google',
            )
        );

        if($basicValidator->fails()) {

            $error_messages = implode(',', $basicValidator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
            Log::info('Registration basic validation failed');

        } else {

            $login_by = $request->login_by;
            $allowedSocialLogin = array('facebook','google');

            // check login-by

            if(in_array($login_by,$allowedSocialLogin)){

                // validate social registration fields

                $socialValidator = Validator::make(
                            $request->all(),
                            array(
                                'social_unique_id' => 'required',
                                'name' => 'required|max:255',
                                'email' => 'required|email|max:255',
                                'mobile' => 'digits_between:6,13',
                                'picture' => '',
                                'gender' => 'in:male,female,others',
                            )
                        );

                if($socialValidator->fails()) {

                    $error_messages = implode(',', $socialValidator->messages()->all());
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);

                    Log::info('Registration social validation failed');

                }else {

                    $check_social_user = User::where('email' , $request->email)->first();

                    if($check_social_user) {
                        $new_user = DEFAULT_FALSE;
                    }

                    Log::info('Registration passed social validation');
                    $operation = true;
                }

            } else {

                // Validate manual registration fields

                $manualValidator = Validator::make(
                    $request->all(),
                    array(
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'mobile' => 'required|digits_between:6,13',
                        'password' => 'required|min:6',
                        'picture' => 'mimes:jpeg,jpg,bmp,png',
                    )
                );

                // validate email existence

                $emailValidator = Validator::make(
                    $request->all(),
                    array(
                        'email' => 'unique:users,email',
                    )
                );

                if($manualValidator->fails()) {

                    $error_messages = implode(',', $manualValidator->messages()->all());
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration manual validation failed');

                } elseif($emailValidator->fails()) {

                    $error_messages = implode(',', $emailValidator->messages()->all());
                    $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
                    Log::info('Registration manual email validation failed');

                } else {
                    Log::info('Registration passed manual validation');
                    $operation = true;
                }

            }

            if($operation) {

                // Creating the user
                if($new_user) {
                    $user = new User;
                    register_mobile($request->device_type);
                } else {
                    $user = $check_social_user;
                }

                if($request->has('name')) {
                    $user->name = $request->name;
                }

                if($request->has('email')) {
                    $user->email = $request->email;
                }

                if($request->has('mobile')) {
                    $user->mobile = $request->mobile;
                }

                if($request->has('password'))
                    $user->password = Hash::make($request->password);

                $user->gender = $request->has('gender') ? $request->gender : "male";

                $user->token = Helper::generate_token();
                $user->token_expiry = Helper::generate_token_expiry();

                $check_device_exist = User::where('device_token', $request->device_token)->first();

                if($check_device_exist){
                    $check_device_exist->device_token = "";
                    $check_device_exist->save();
                }

                $user->device_token = $request->has('device_token') ? $request->device_token : "";
                $user->device_type = $request->has('device_type') ? $request->device_type : "";
                $user->login_by = $request->has('login_by') ? $request->login_by : "";
                $user->social_unique_id = $request->has('social_unique_id') ? $request->social_unique_id : '';

                $user->picture = asset('placeholder.png');

                // Upload picture
                if($request->login_by == "manual") {

                    if($request->hasFile('picture')) {
                        $user->picture = Helper::normal_upload_picture($request->file('picture'));
                    }
                } else {
                    if($request->has('picture')) {
                        $user->picture = $request->picture;
                    }
                }

                $user->is_activated = 1;
                $user->user_type = 1;

                $user->save();


                // Send welcome email to the new user:
                if($new_user) {
                    $subject = tr('user_welcome_title');
                    $email_data = $user;
                    $page = "emails.welcome";
                    $email = $user->email;
                    // Helper::send_email($page,$subject,$email,$email_data);
                }

                // Response with registered user details:

                $response_array = array(
                    'success' => true,
                    'id' => $user->id,
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                    'gender' => $user->gender,
                    'email' => $user->email,
                    'picture' => $user->picture,
                    'token' => $user->token,
                    'token_expiry' => $user->token_expiry,
                    'login_by' => $user->login_by,
                    'user_type' => $user->user_type,
                    'social_unique_id' => $user->social_unique_id,
                    'push_status' => $user->push_status,
                );

                $response_array = Helper::null_safe($response_array);

                Log::info('Registration completed');

            }

        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function login(Request $request) {

        $response_array = array();
        $operation = false;

        $basicValidator = Validator::make(
            $request->all(),
            array(
                'device_token' => 'required',
                'device_type' => 'required|in:'.DEVICE_ANDROID.','.DEVICE_IOS,
                'login_by' => 'required|in:manual,facebook,google',
            )
        );

        if($basicValidator->fails()){
            
            $error_messages = implode(',',$basicValidator->messages()->all());
            
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
        
        } else {

            $login_by = $request->login_by;
            /*validate manual login fields*/
            $manualValidator = Validator::make(
                $request->all(),
                array(
                    'email' => 'required|email',
                    'password' => 'required',
                )
            );

            if ($manualValidator->fails()) {
                $error_messages = implode(',',$manualValidator->messages()->all());
                $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
            
            } else {

                // Validate the user credentials
                if($user = User::where('email', '=', $request->email)->first()) {

                    if($user->is_activated) {

                        if(Hash::check($request->password, $user->password)){

                            /*manual login success*/
                            $operation = true;

                        } else {
                            $response_array = array( 'success' => false, 'error' => Helper::get_error_message(105), 'error_code' => 105 );
                        }
                    } else {
                        $response_array = array('success' => false , 'error' => Helper::get_error_message(144),'error_code' => 144);
                    }

                } else {
                    $response_array = array( 'success' => false, 'error' => Helper::get_error_message(105), 'error_code' => 105 );
                }
            
            }

            if($operation) {

                // Generate new tokens
                $user->token = Helper::generate_token();
                $user->token_expiry = Helper::generate_token_expiry();

                // Save device details
                $user->device_token = $request->device_token;
                $user->device_type = $request->device_type;
                $user->login_by = $request->login_by;

                $user->save();

                $payment_mode_status = $user->payment_mode ? $user->payment_mode : 0;

                // Respond with user details

                $response_array = array(
                    'success' => true,
                    'id' => $user->id,
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                    'gender' => $user->gender,
                    'picture' => $user->picture,
                    'token' => $user->token,
                    'token_expiry' => $user->token_expiry,
                    'login_by' => $user->login_by,
                    'user_type' => $user->user_type,
                    'social_unique_id' => $user->social_unique_id,
                    'push_status' => $user->push_status,
                );

                $response_array = Helper::null_safe($response_array);
            
            }
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function forgot_password(Request $request) {

        $email =$request->email;
        // Validate the email field
        $validator = Validator::make(
            $request->all(),
            array(
                'email' => 'required|email|exists:users,email',
            )
        );

        if ($validator->fails()) {
            
            $error_messages = implode(',',$validator->messages()->all());
            
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=> $error_messages);
        
        } else {

            $user = User::where('email' , $email)->first();

            if($user) {

                $new_password = Helper::generate_password();
                $user->password = Hash::make($new_password);

                $email_data = array();
                $subject = tr('user_forgot_email_title');
                $email = $user->email;
                $email_data['user']  = $user;
                $email_data['password'] = $new_password;
                $page = "emails.forgot-password";
                $email_send = Helper::send_email($page,$subject,$user->email,$email_data);

                $response_array['success'] = true;
                $response_array['message'] = Helper::get_message(106);
                $user->save();

            }

        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function change_password(Request $request) {

        $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed',
                'old_password' => 'required',
            ]);

        if($validator->fails()) {
            
            $error_messages = implode(',',$validator->messages()->all());
           
            $response_array = array('success' => false, 'error' => 'Invalid Input', 'error_code' => 401, 'error_messages' => $error_messages );
       
        } else {

            $user = User::find($request->id);

            if(Hash::check($request->old_password,$user->password)) {

                $user->password = Hash::make($request->new_password);
                
                $user->save();

                $response_array = Helper::null_safe(array('success' => true , 'message' => Helper::get_message(102)));

            } else {
                $response_array = array('success' => false , 'error' => Helper::get_error_message(131),'error_messages' => Helper::get_error_message(131) ,'error_code' => 131);
            }

        }

        $response = response()->json($response_array,200);
        return $response;

    }

    public function user_details(Request $request) {

        $user = User::find($request->id);

        $response_array = array(
            'success' => true,
            'id' => $user->id,
            'name' => $user->name,
            'mobile' => $user->mobile,
            'gender' => $user->gender,
            'email' => $user->email,
            'picture' => $user->picture,
            'token' => $user->token,
            'token_expiry' => $user->token_expiry,
            'login_by' => $user->login_by,
            'social_unique_id' => $user->social_unique_id
        );
        $response = response()->json(Helper::null_safe($response_array), 200);
        return $response;
    }

    public function update_profile(Request $request) {
        
        $validator = Validator::make(
            $request->all(),
            array(
                'name' => 'required|max:255',
                'email' => 'email|unique:users,email,'.$request->id.'|max:255',
                'mobile' => 'digits_between:6,13',
                'picture' => 'mimes:jpeg,bmp,png',
                'gender' => 'in:male,female,others',
                'device_token' => '',
            ));

        if ($validator->fails()) {
            // Error messages added in response for debugging
            $error_messages = implode(',',$validator->messages()->all());
            $response_array = array(
                    'success' => false,
                    'error' => Helper::get_error_message(101),
                    'error_code' => 101,
                    'error_messages' => $error_messages
            );
        } else {

            $user = User::find($request->id);

            if($user) {
                
                $user->name = $request->name ? $request->name : $user->name;
                
                if($request->has('email')) {
                    $user->email = $request->email;
                }

                $user->mobile = $request->mobile ? $request->mobile : $user->mobile;
                $user->gender = $request->gender ? $request->gender : $user->gender;
                $user->address = $request->address ? $request->address : $user->address;
                $user->description = $request->description ? $request->description : $user->address;

                // Upload picture
                if ($request->hasFile('picture') != "") {
                    Helper::delete_picture($user->picture, "/uploads/"); // Delete the old pic
                    $user->picture = Helper::normal_upload_picture($request->file('picture'));
                }

                $user->save();
            }

            $payment_mode_status = $user->payment_mode ? $user->payment_mode : "";

            $response_array = array(
                'success' => true,
                'id' => $user->id,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'gender' => $user->gender,
                'email' => $user->email,
                'picture' => $user->picture,
                'token' => $user->token,
                'token_expiry' => $user->token_expiry,
                'login_by' => $user->login_by,
                'social_unique_id' => $user->social_unique_id,
            );

            $response_array = Helper::null_safe($response_array);
        
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function delete_account(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'password' => '',
            ));

        if ($validator->fails()) {
            $error_messages = implode(',',$validator->messages()->all());
            $response_array = array('success' => false,'error' => Helper::get_error_message(101),'error_code' => 101,'error_messages' => $error_messages
            );
        } else {

            $user = User::find($request->id);

            if($user->login_by != 'manual') {
                $allow = 1;
            } else {

                if(Hash::check($request->password, $user->password)) {
                    $allow = 1;
                } else {
                    $allow = 0 ;

                    $response_array = array('success' => false , 'error' => Helper::get_error_message(108) ,'error_code' => 108);
                }

            }

            if($allow) {

                $user = User::where('id',$request->id)->first();

                if($user) {
                    $user->delete();
                    $response_array = array('success' => true , 'message' => tr('user_account_delete_success'));
                } else {
                    $response_array = array('success' =>false , 'error' => Helper::get_error_message(146), 'error_code' => 146);
                }

            }

        }

		return response()->json($response_array,200);

	}

	public function user_rating(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'admin_video_id' => 'required|integer|exists:admin_videos,id',
                'rating' => 'integer|in:'.RATINGS,
                'comments' => '',
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists please provide correct video id',
                'unique' => 'The :attribute already rated.'
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            //Save Rating
            $rating = new UserRating();
            $rating->user_id = $request->id;
            $rating->admin_video_id = $request->admin_video_id;
            $rating->rating = $request->has('rating') ? $request->rating : 0;
            $rating->comment = $request->comments ? $request->comments: '';
            $rating->save();

			$response_array = array('success' => true , 'comment' => $rating->toArray() , 'date' => $rating->created_at->diffForHumans(),'message' => tr('comment_success') );
        }

        $response = response()->json($response_array, 200);
        return $response;
    
    }

    public function add_wishlist(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'admin_video_id' => 'required|integer|exists:admin_videos,id',
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists please provide correct video id',
                'unique' => 'The :attribute already added in wishlist.'
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            $wishlist = Wishlist::where('user_id' , $request->id)->where('admin_video_id' , $request->admin_video_id)->first();

            $status = 1;

            if(count($wishlist) > 0) {

                if($wishlist->status == 1)
                    $status = 0;

                $wishlist->status = $status;
                $wishlist->save();
            } else {

                //Save Wishlist
                $wishlist = new Wishlist();
                $wishlist->user_id = $request->id;
                $wishlist->admin_video_id = $request->admin_video_id;
                $wishlist->status = $status;
                $wishlist->save();
            }
            if($status)
                $message = "Added to wishlist";
            else
                $message = "Removed from wishlist";

            $response_array = array('success' => true ,'wishlist_id' => $wishlist->id , 'wishlist_status' => $wishlist->status,'message' => $message);
        }

        $response = response()->json($response_array, 200);
        return $response;
    
    }

    public function get_wishlist(Request $request)  {

        $wishlist = Helper::wishlist($request->id,NULL,$request->skip);

        $total = get_wishlist_count($request->id);

		$response_array = array('success' => true, 'wishlist' => $wishlist , 'total' => $total);

        return response()->json($response_array, 200);
    
    }

    public function delete_wishlist(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'wishlist_id' => 'integer|exists:wishlists,id,user_id,'.$request->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists please add to wishlists',
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            /** Clear All wishlist of the loggedin user */

            if($request->status == 1) {

                $wishlist = Wishlist::where('user_id',$request->id)->delete();

            } else {  /** Clear particularv wishlist of the loggedin user */

                $wishlist = Wishlist::where('id',$request->wishlist_id)->delete();
            }

			$response_array = array('success' => true);
        }

        $response = response()->json($response_array, 200);
        return $response;
    
    }

    public function add_history(Request $request)  {

        $validator = Validator::make(
            $request->all(),
            array(
                'admin_video_id' => 'required|integer|exists:admin_videos,id',
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists please provide correct video id',
                'unique' => 'The :attribute already added in history.'
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            if($history = UserHistory::where('user_id' , $request->id)->where('admin_video_id' ,$request->admin_video_id)->first()) {

                $response_array = array('success' => true , 'error' => Helper::get_error_message(145) , 'error_code' => 145);

            } else {

                //Save Wishlist
                $rev_user = new UserHistory();
                $rev_user->user_id = $request->id;
                $rev_user->admin_video_id = $request->admin_video_id;
                $rev_user->save();

                if($video = AdminVideo::find($request->admin_video_id)) {
                    $video->watch_count = $video->watch_count + 1;
                    $video->save();
                }

                $response_array = array('success' => true);
            }
        }
        return response()->json($response_array, 200);
    
    }

    public function get_history(Request $request) {

		//get wishlist

        $history = Helper::watch_list($request->id,NULL,$request->skip)->toArray();

        $total = get_history_count($request->id);

		$response_array = array('success' => true, 'history' => $history , 'total' => $total);

        return response()->json($response_array, 200);
    
    }

    public function delete_history(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'history_id' => 'integer|exists:user_histories,id,user_id,'.$request->id,
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists please add to history',
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);
        } else {

            if($request->has('status')) {
                $history = UserHistory::where('user_id',$request->id)->delete();
            } else {
                //delete history
                $history = UserHistory::where('user_id',$request->id)->where('id' ,  $request->history_id )->delete();
            }

            $response_array = array('success' => true);
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function get_categories(Request $request) {

        $categories = get_categories();

        if($categories) {

            $response_array = array('success' => true , 'categories' => $categories->toArray());

        } else {
            $response_array = array('success' => false,'error' => Helper::get_error_message(135),'error_code' => 135);
        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function get_sub_categories(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'category_id' => 'required|integer|exists:categories,id',
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists',
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            $sub_categories = get_sub_categories($request->category_id);

            if($sub_categories) {

                $response_array = array('success' => true , 'sub_categories' => $sub_categories->toArray());

            } else {
                $response_array = array('success' => false,'error' => Helper::get_error_message(130),'error_code' => 130);
            }

        }

        $response = response()->json($response_array, 200);
        return $response;
    }

    public function home(Request $request) {

        $videos = $wishlist = $recent =  $banner = $trending = $history = $suggestion =array();

        $banner['name'] = tr('mobile_banner_heading');
        $banner['key'] = BANNER;
        $banner['list'] = Helper::banner_videos();

        $wishlist['name'] = tr('mobile_wishlist_heading');
        $wishlist['key'] = WISHLIST;
        $wishlist['list'] = Helper::wishlist($request->id);

        array_push($videos , $wishlist);

        $recent['name'] = tr('mobile_recent_upload_heading');
        $recent['key'] = RECENTLY_ADDED;
        $recent['list'] = Helper::recently_added();

        array_push($videos , $recent);

        $trending['name'] = tr('mobile_trending_heading');
        $trending['key'] = TRENDING;
        $trending['list'] = Helper::trending();

        array_push($videos, $trending);

        $history['name'] = tr('mobile_watch_again_heading');
        $history['key'] = WATCHLIST;
        $history['list'] = Helper::watch_list($request->id);

        array_push($videos , $history);

        $suggestion['name'] = tr('mobile_suggestion_heading');
        $suggestion['key'] = SUGGESTIONS;
        $suggestion['list'] = Helper::suggestion_videos();

        array_push($videos , $suggestion);

        $response_array = array('success' => true , 'data' => $videos , 'banner' => $banner);

        return response()->json($response_array , 200);

    }

    public function common(Request $request) {

        $key = $request->key;

        $total = 18;

        switch($key) {
            case TRENDING:
                $videos = Helper::trending(NULL,$request->skip);
                break;
            case WISHLIST:
                $videos = Helper::wishlist($request->id,NULL,$request->skip);
                $total = get_wishlist_count($request->id);
                break;
            case SUGGESTIONS:
                $videos = Helper::suggestion_videos(NULL,$request->skip);
                break;
            case RECENTLY_ADDED:
                $videos = Helper::recently_added(NULL,$request->skip);
                break;
            case WATCHLIST:
                $videos = Helper::watch_list($request->id,NULL,$request->skip);
                $total = get_history_count($request->id);
                break;
            default:
                $videos = Helper::recently_added(NULL,$request->skip);
        }


        $response_array = array('success' => true , 'data' => $videos , 'total' => $total);

        return response()->json($response_array , 200);

    }

    public function get_category_videos(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'category_id' => 'required|integer|exists:categories,id',
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists',
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            $data = array();

            $sub_categories = get_sub_categories($request->category_id);

            if($sub_categories) {

                foreach ($sub_categories as $key => $sub_category) {

                    $videos = Helper::sub_category_videos($sub_category->id);

                    if(count($videos) > 0) {

                        $results['sub_category_name'] = $sub_category->name;
                        $results['key'] = $sub_category->id;
                        $results['videos_count'] = count($videos);
                        $results['videos'] = $videos->toArray();

                        array_push($data, $results);
                    }
                }
            }

            $response_array = array('success' => true, 'data' => $data);
        }

        $response = response()->json($response_array, 200);
        return $response;

    }

    public function get_sub_category_videos(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'sub_category_id' => 'required|integer|exists:sub_categories,id',
                'skip' => 'integer'
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists',
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            $data = array();

            $total = 18;

            if($videos = Helper::sub_category_videos($request->sub_category_id , NULL,$request->skip)) {
                $data = $videos->toArray();
            }

            $total = get_sub_category_video_count($request->sub_category_id);

            $response_array = array('success' => true, 'data' => $data , 'total' => $total);

        }

        $response = response()->json($response_array, 200);
        
        return $response;

    }

    public function single_video(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'admin_video_id' => 'required|integer|exists:admin_videos,id',
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists',
            )
        );

        if ($validator->fails()) {
            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            $data = array();

            $data = Helper::get_video_details($request->admin_video_id);

            $trailer_video = $ios_trailer_video = $data->trailer_video;

            $video = $ios_video = $data->video;

            if($data->video_type == 1 && $data->video_upload_type == 2) {

                if(check_valid_url($data->tralier_video)) {

                    if(Setting::get('streaming_url'))
                        $trailer_video = Setting::get('streaming_url').get_video_end($data->trailer_video);

                    if(envfile('HLS_STREAMING_URL'))
                        $ios_trailer_video = envfile('HLS_STREAMING_URL').get_video_end($data->trailer_video);
                }

                if(check_valid_url($data->video)) {

                    if(Setting::get('streaming_url'))
                        $video = Setting::get('streaming_url').get_video_end($data->video);

                    if(envfile('HLS_STREAMING_URL'))
                        $ios_video = envfile('HLS_STREAMING_URL').get_video_end($data->video);
                }
            }

            $admin_video_images = AdminVideoImage::where('admin_video_id' , $request->admin_video_id)
                                ->orderBy('is_default' , 'desc')
                                ->get();

            if($ratings = Helper::video_ratings($request->admin_video_id,0)) {
                $ratings = $ratings->toArray();
            }

            $wishlist_status = Helper::wishlist_status($request->admin_video_id,$request->id);
            $history_status = Helper::history_status($request->id,$request->admin_video_id);
            $share_link = route('user.single' , $request->admin_video_id);

            $user = User::find($request->id);

            $response_array = array(
                        'success' => true,
                        'user_type' => $user->user_type ? $user->user_type : 0,
                        'wishlist_status' => $wishlist_status,
                        'history_status' => $history_status,
                        'share_link' => $share_link,
                        'main_video' => $video,
                        'tralier_video' => $trailer_video,
                        'ios_video' => $ios_video,
                        'ios_tralier_video' => $ios_trailer_video,
                        'video' => $data ,
                        'video_images' => $admin_video_images,
                        'comments' => $ratings
                        );
        }

        $response = response()->json($response_array, 200);
        return $response;

    }

    public function search_video(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'key' => '',
            ),
            array(
                'exists' => 'The :attribute doesn\'t exists',
            )
        );

        if ($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            $results = AdminVideo::where('is_approved' , 1)->where('status' , 1)->select('id as admin_video_id' , 'title' , 'default_image')->orderBy('created_at' , 'desc')->get()->toArray();

            $response_array = array('success' => true, 'data' => $results);
        }

        $response = response()->json($response_array, 200);
        return $response;

    }

    public function privacy(Request $request) {

        $page_data['type'] = $page_data['heading'] = $page_data['content'] = "";

        $page = Page::where('type', 'privacy')->first();

        if($page) {

            $page_data['type'] = "privacy";
            $page_data['heading'] = $page->heading;
            $page_data ['content'] = $page->description;
        }

        $response_array = array('success' => true , 'page' => $page_data);

        return response()->json($response_array,200);

    }

    public function about(Request $request) {

        $page_data['type'] = $page_data['heading'] = $page_data['content'] = "";

        $page = Page::where('type', 'about')->first();

        if($page) {

            $page_data['type'] = 'about';

            $page_data['heading'] = $page->heading;

            $page_data ['content'] = $page->description;
        }

        $response_array = array('success' => true , 'page' => $page_data);
        return response()->json($response_array,200);

    }

    public function terms(Request $request) {

        $page_data['type'] = $page_data['heading'] = $page_data['content'] = "";

        $page = Page::where('type', 'terms')->first();

        if($page) {

            $page_data['type'] = "Terms";

            $page_data['heading'] = $page->heading;

            $page_data ['content'] = $page->description;
        }

        $response_array = array('success' => true , 'page' => $page_data);
        return response()->json($response_array,200);

    }

    public function settings(Request $request) {

        $validator = Validator::make(
            $request->all(),
            array(
                'status' => 'required',
            )
        );

        if ($validator->fails()) {

            $error_messages = implode(',', $validator->messages()->all());
            $response_array = array('success' => false, 'error' => Helper::get_error_message(101), 'error_code' => 101, 'error_messages'=>$error_messages);

        } else {

            $user = User::find($request->id);
            $user->push_status = $request->status;
            $user->save();

            if($request->status) {
                $message = tr('push_notification_enable');
            } else {
                $message = tr('push_notification_disable');
            }

            $response_array = array('success' => true, 'message' => $message , 'push_status' => $user->push_status);
        }

        $response = response()->json($response_array, 200);
        return $response;
    }


}
