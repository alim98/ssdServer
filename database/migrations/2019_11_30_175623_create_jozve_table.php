<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJozveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('desc')->nullable();
            $table->string('profile_url')->nullable();
            $table->smallInteger('likes_count')->unsigned()->default(0);
            $table->bigInteger('student_id')->unsigned();
            //size
            //grade
            //major
            $table->timestamps();
            $table->foreign('student_id')->references('phone_number')->on('students')->onDelete('cascade');
          //  $table->primary(['student_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jozve');
    }
}
