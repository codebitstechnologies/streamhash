<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeVideoIdInAdminVideoImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_video_images', function (Blueprint $table) {
            DB::statement("ALTER TABLE admin_video_images CHANGE video_id admin_video_id INT( 11 ) NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_video_images', function (Blueprint $table) {
            $table->dropColumn('admin_video_id');
        });
    }
}
