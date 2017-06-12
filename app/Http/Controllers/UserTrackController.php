<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\UserTrack;

class UserTrackController extends Controller {

    public function track_user(Request $request) {

        $ip_address = $_SERVER['REMOTE_ADDR'];

        if($ip_address) {

            $check_user = $track_user UserTrack::where('ip_address' , $ip_address)->first();

            if(!$check_user) {

            	$details = json_decode(file_get_contents("http://ipapi.co/{$ip_address}/json"));

            	$track_user = new UserTrack;

            }

            $track_user->ip_address = $ip_address;
            
            $track_user->HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT']: ""; 
            $track_user->REQUEST_TIME = $_SERVER['REQUEST_TIME'] ? $_SERVER['REQUEST_TIME']: ""; 
            $track_user->REMOTE_ADDR = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR']: ""; 

            if($details) {

	            $track_user->city  = $details->city;
	            $track_user->region  = $details->region;
	            $track_user->country  = $details->country;
	            $track_user->postal  = $details->postal;
	            $track_user->latitude  = $details->latitude;
	            $track_user->longitude  = $details->longitude;
	            $track_user->timezone = $details->timezone;
	        
	        }

	        $track_user->save();
            
        }
        
    }
}
