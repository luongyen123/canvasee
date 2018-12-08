<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('content',255);
            $table->integer('user_id');
            $table->integer('group_id');
            $table->string('likes');
            $table->string('shares');
            $table->string('comments');
            $table->string('notifications');
            $table->string('medias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
    }
}
