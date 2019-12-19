<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('comment_id')->primary();
            $table->uuid('post_id');
            $table->bigInteger('student_id')->unsigned();
            $table->string('comment');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade');
            $table->foreign('student_id')->references('phone_number')->on('students')->onDelete('cascade');

           // $table->primary(['post_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
