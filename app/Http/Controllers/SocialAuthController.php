<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use Hash;
use App\Helpers\Helper;

class SocialAuthController extends Controller
{
    public function redirect(Request $request)
    {
        return Socialite::driver($request->provider)->redirect();
    }

    public function callback(Request $request ,$provider)
	{

		$social_user = \Socialite::driver($provider)->user();

		$user = User::where('social_unique_id' , $social_user->id)->where('login_by' , $provider)->first();

		if(!count($user)) {

			$user = new User;
			$user->social_unique_id = $social_user->id;
			$user->login_by = $provider;
			$user->is_activated = 1;

			if($social_user->name) {
				$user->name = $social_user->name;
			} else {
				$user->name = "Dummy";
			}

			if($social_user->email && !User::where('email',$social_user->email)->first()) {
				$user->email = $social_user->email;
			} else {
				$user->email = "social".uniqid()."@streamhash.com";
			}

			// Save Dummy details
			$user->picture =  asset('placeholder.png');

			if(in_array($provider, array('facebook','twitter'))) {
				if($social_user->avatar_original) {
					$user->picture = $social_user->avatar_original;
				}
			}

			$user->is_activated = DEFAULT_TRUE;
			$user->password = Hash::make($social_user->id);

            $user->token = Helper::generate_token();
            $user->token_expiry = Helper::generate_token_expiry();

			$user->save();

		}

	    auth()->login($user);

	    return redirect()->route('user.dashboard');
	}
}
