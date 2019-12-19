<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow', function (Blueprint $table) {
            $table->bigInteger('follower_id')->unsigned();
            $table->bigInteger('following_id')->unsigned();
            $table->timestamps();

            $table->foreign('follower_id')->references('phone_number')->on('students')->onDelete('cascade');
            $table->foreign('following_id')->references('phone_number')->on('students')->onDelete('cascade');

            $table->primary(['follower_id', 'following_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow');
    }
}
