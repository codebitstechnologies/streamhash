<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayPerViewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_videos', function (Blueprint $table) {
            $table->integer('type_of_user')->default(0)->after('watch_count');
            $table->integer('type_of_subscription')->default(0)->after('type_of_user');
            $table->integer('amount')->default(0)->after('type_of_subscription');
            // $table->time('duration')->after('publish_time');
            $table->time('trailer_duration')->after('duration');
            $table->string('video_resolutions')->nullable()->after('trailer_duration');
            $table->string('trailer_video_resolutions')->nullable()->after('video_resolutions');
            $table->integer('compress_status')->default(0)->after('trailer_video_resolutions');
            $table->integer('trailer_compress_status')->default(0)->after('compress_status');
            $table->longText('video_resize_path')->nullable()->after('trailer_compress_status');
            $table->longText('trailer_resize_path')->nullable()->after('video_resize_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_videos', function (Blueprint $table) {
            $table->dropColumn('type_of_user');
            $table->dropColumn('type_of_subscription');
            $table->dropColumn('amount');
            // $table->dropColumn('duration');
            $table->dropColumn('trailer_duration');
            $table->dropColumn('video_resolutions');
            $table->dropColumn('trailer_video_resolutions');
            $table->dropColumn('compress_status');
            $table->dropColumn('trailer_compress_status');
            $table->dropColumn('video_resize_path');
            $table->dropColumn('trailer_resize_path');
        });
    }
}
