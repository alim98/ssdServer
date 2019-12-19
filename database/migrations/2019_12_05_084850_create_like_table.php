<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like', function (Blueprint $table) {
            $table->uuid('like_id')->primary();
            $table->uuid('post_id');
            $table->bigInteger('student_id')->unsigned();
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade');
            $table->foreign('student_id')->references('phone_number')->on('students')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like');
    }
}
