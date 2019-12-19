<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uni', function (Blueprint $table) {
            $table->smallInteger('uni_code')->unsigned();
            $table->string('name');
            $table->string("phone_number")->nullable();
            $table->string("address")->nullable();
            $table->timestamps();
            $table->primary('uni_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uni');
    }
}
