<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savedposts', function (Blueprint $table) {
            $table->uuid('saved_id')->primary();
            $table->bigInteger('student_id')->unsigned();
            $table->uuid('post_id');
            $table->timestamps();

            $table->foreign('student_id')->references('phone_number')->on('students')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savedposts');
    }
}
