<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();
    	DB::table('settings')->insert([
    		[
		        'key' => 'site_name',
		        'value' => 'StreamHash'
		    ],
		    [
		        'key' => 'site_logo',
		        'value' => ''
		    ],
		    [
		        'key' => 'site_icon',
		        'value' => ''
		    ],
		    [
		        'key' => 'tag_name',
		        'value' => ''
		    ],
		    [
		        'key' => 'paypal_email',
		        'value' => ''
		    ],
		    [
		        'key' => 'browser_key',
		        'value' => ''
		    ],
		    [
		        'key' => 'default_lang',
		        'value' => 'en'
		    ], 
		    [
		        'key' => 'currency',
		        'value' => '$'
		    ],
		    [
	            'key' => 'admin_delete_control',
			    'value' => 1        	
			],
        	[
	        	'key' => 'admin_theme_control',
			    'value' => 1
        	],
        	[
		        'key' => 'theme',
		        'value' => 'streamtube'
		    ],
		    [
		        'key' => 'paypal_client_id',
		        'value' => ''
		    ],
		    [
		        'key' => 'paypal_secret',
		        'value' => ''
		    ],
		    [
		        'key' => 'installation_process',
		        'value' => 0
		    ],
		    [
		        'key' => 'amount',
		        'value' => 10
		    ],
		    [
		        'key' => 'expiry_days',
		        'value' => 28
		    ],
		    [
        		'key' => 'admin_take_count',
        		'value' => 12
        	],
		    [
		        'key' => 'google_analytics',
		        'value' => ""
		    ],
		    [
        		'key' => 'streaming_url',
        		'value' => ''
        	],
		    [
		    	'key' => 'video_compress_size',
		    	'value' => 2
		    ],
		    [
		    	'key' => 'image_compress_size',
		    	'value' => 8
		    ],
		    [
		        'key' => 's3_key',
		        'value' => ''
		    ],
		    [
		        'key' => 's3_secret',
		        'value' => ''
		    ],
		    [
		        'key' => 's3_region',
		        'value' => ''
		    ],
		    [
		        'key' => 's3_bucket',
		        'value' => ''
		    ],
		    [
		        'key' => 'track_user_mail',
		        'value' => ''
		    ],
		    [
	            'key' => 'REPORT_VIDEO',
			    'value' => 'Sexual content'
		    ],
		    [
	            'key' => 'REPORT_VIDEO',
			    'value' => 'Violent or repulsive content.'
		    ],
		    [
	            'key' => 'REPORT_VIDEO',
			    'value' => 'Hateful or abusive content.'
		    ],
		    [
	            'key' => 'REPORT_VIDEO',
			    'value' => 'Harmful dangerous acts.'
		    ],
		    [
	            'key' => 'REPORT_VIDEO',
			    'value' => 'Child abuse.'
		    ],
		    [
	            'key' => 'REPORT_VIDEO',
			    'value' => 'Spam or misleading.'
		    ],
		    [
	            'key' => 'REPORT_VIDEO',
			    'value' => 'Infringes my rights.'
		    ],
		    [
	            'key' => 'REPORT_VIDEO',
			    'value' => 'Captions issue.'
		    ],
		    [
	            'key' => 'VIDEO_RESOLUTIONS',
			    'value' => '426x240'
		    ],
		    [
	            'key' => 'VIDEO_RESOLUTIONS',
			    'value' => '640x360'
		    ],
		    [
	            'key' => 'VIDEO_RESOLUTIONS',
			    'value' => '854x480'
		    ],
		    [
	            'key' => 'VIDEO_RESOLUTIONS',
			    'value' => '1280x720'
		    ],
		    [
	            'key' => 'VIDEO_RESOLUTIONS',
			    'value' => '1920x1080'
		    ]
		]);
    }
}
