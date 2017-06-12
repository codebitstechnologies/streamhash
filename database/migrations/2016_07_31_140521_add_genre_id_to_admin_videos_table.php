<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenreIdToAdminVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_videos', function (Blueprint $table) {
            DB::statement('ALTER TABLE  admin_videos CHANGE  genar_id  genre_id INT(11) NOT NULL');
            DB::statement('ALTER TABLE  admin_videos CHANGE  video  video varchar(255) NOT NULL');
            DB::statement('ALTER TABLE  admin_videos CHANGE  trailer_video  trailer_video varchar(255) NOT NULL');
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
            $table->dropColumn('genre_id');
        });
    }
}