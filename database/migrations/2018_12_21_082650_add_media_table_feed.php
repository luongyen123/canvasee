<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMediaTableFeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->text('media_image')->nullable();
            $table->text('media_video')->nullable();
            $table->text('media_link')->nullable();
            $table->dropColumn('medias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
