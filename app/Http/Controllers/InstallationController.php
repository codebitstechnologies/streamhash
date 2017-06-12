<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Setting;

use App\Settings;

use App\Helpers\Helper;

class InstallationController extends Controller {

    public function install() {

        $settings = Setting::get('installation_process');

        if( $settings == NO_INSTALL) {
            $title = "System Check";
            return view('install.system-check')->with('title' , $title)->with('page' , 'system_check');
        } 
        if ($settings == SYSTEM_CHECK) {
            $title = "Choose Theme";
            return view('install.install-theme')->with('title' , $title)->with('page' , 'theme_install');
        } 

        if($settings == THEME_CHECK ) {
            $title = "Configure Site Settings";

            return view('install.install-others')->with('title' , $title)->with('page' , 'other_install');
        }

        if($settings == INSTALL_COMPLETE) {
            // return view('admin.auth.login')->with('flash_success' , "Installation Process is done"); 

            return redirect()->route('admin.login')->with('flash_success' , "Installation Process is done");
        }
        
        return redirect()->route('admin.login')->with('flash_success' , "Installation Process is done"); 
    
    }

    public function system_check_process() {

    	$Settings = Settings::where('key' , 'installation_process')->first();

    	if($Settings) {
    		$Settings->value = SYSTEM_CHECK;
    		$Settings->save();
    	}

    	if($Settings) {
    		return redirect()->route('installTheme');	
    	} else {
            return back();
        }
    }

    public function theme_check_process(Request $request) {

    	$Settings = Settings::where('key' , 'installation_process')->first();

    	if($Settings) {
    		$Settings->value = THEME_CHECK;
    		$Settings->save();
    	}

    	if($theme = Settings::where('key' , 'theme')->first()) {

    		change_theme($theme->value , $request->theme);

            $theme->value = $request->theme;
            $theme->save();
    	}

    	if($Settings) {
    		return redirect()->route('installTheme');  	
    	} 
        return back();    	
    }

    public function settings_process(Request $request) {
    	
    	$Settings = Settings::where('key' , 'installation_process')->first();

    	if($Settings) {
    		$Settings->value = INSTALL_COMPLETE;
    		$Settings->save();
    	}

        $settings = Settings::all();

        foreach ($settings as $setting) {

            $key = $setting->key;
           
            $temp_setting = Settings::find($setting->id);

                if($temp_setting->key == 'site_icon'){
                    $site_icon = $request->file('site_icon');
                    if($site_icon == null) {
                        $icon = $temp_setting->value;
                    } else {

                        if($temp_setting->value) {
                            Helper::delete_picture($temp_setting->value, "/uploads/");
                        }

                        $icon = Helper::normal_upload_picture($site_icon);
                    }

                    $temp_setting->value = $icon;
                    
                } else if($temp_setting->key == 'site_logo'){
                    $picture = $request->file('site_logo');
                    if($picture == null){
                        $logo = $temp_setting->value;
                    } else {
                        if($temp_setting->value) {
                            Helper::delete_picture($temp_setting->value, "/uploads/");
                        }
                        $logo = Helper::normal_upload_picture($picture);
                    }

                    $temp_setting->value = $logo;

                } else if($request->$key!=''){  
                    $temp_setting->value = $request->$key;
                }
            $temp_setting->save();
        }
        // Delete the installation related folders
        // delete_install();
        return redirect()->route('installTheme');
    }
}
