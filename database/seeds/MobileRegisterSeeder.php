<?php

use Illuminate\Database\Seeder;

class MobileRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('mobile_registers')->insert([
    		[
		        'type' => 'android',
		        'count' => 0
		    ],
		    [
		        'type' => 'ios',
		        'count' => 0
		    ],
		    [
		        'type' => 'web',
		        'count' => 0
		    ],
		]);
    }
}
