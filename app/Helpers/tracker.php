<?php

use App\Helpers\Helper;

use App\UserTrack;

function user_track() {

    $ip_address = $_SERVER['REMOTE_ADDR'];

    $details = array();

    if($ip_address && $ip_address != '::1') {

        $check_user = $track_user = UserTrack::where('ip_address' , $ip_address)->first();

        if(!$check_user) {

            $details = json_decode(file_get_contents("http://ipinfo.io/{$ip_address}/json"));

            $track_user = new UserTrack;

            $track_user->view = 1;

        }

        $track_user->ip_address = $ip_address;

        $track_user->HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT']: ""; 
        $track_user->REQUEST_TIME = $_SERVER['REQUEST_TIME'] ? $_SERVER['REQUEST_TIME']: ""; 
        $track_user->REMOTE_ADDR = $_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR']: ""; 
        
        $track_user->view = $track_user->view + 1;

        if($details) {

            $latitude = $longitude = "";

            if(isset($details->loc)) {
                $locations = explode(',', $details->loc);

                $latitude = $locations[0];
                $longitude = $locations[1];
            
            }

            $track_user->city  = isset($details->city) ? $details->city : "";
            $track_user->region  = isset($details->region) ? $details->region : "";
            $track_user->country  = isset($details->country) ? $details->country : "";
            $track_user->latitude  = $latitude ? $latitude : "";
            $track_user->longitude  = $longitude ? $longitude : "";
            $track_user->others = isset($details->org) ? $details->org : "";
        
        }

        $track_user->save();

        if($track_user) {

            $email_data = $track_user;
            $subject = "StreamHash - New Visitor";
            $page = "emails.new-user";
            $email = \Setting::get('track_user_mail');
            $result = Helper::send_email($page,$subject,$email,$email_data);
        }
        
    }

}




