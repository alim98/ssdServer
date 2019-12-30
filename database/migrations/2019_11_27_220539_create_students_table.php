<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigInteger('phone_number')->unsigned();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('api_token', 80)->unique()->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('full_name');
            $table->string('grade')->nullable();
            $table->string('profile_url')->nullable();
            $table->smallInteger('followers_count')->default(0);
            $table->smallInteger('followings_count')->default(0);
            $table->smallInteger('posts_count')->default(0);
            $table->string('field')->nullable();
            $table->smallInteger('uni_code')->unsigned()->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('uni_code')->references('uni_code')->on('uni')->onDelete('cascade');
            $table->primary('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
