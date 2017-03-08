<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsorders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobsorders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->integer('client_id');
            $table->integer('car_id');
            $table->string('description');
            $table->string('progress');
            $table->tinyInteger('pirority');
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
        Schema::dropIfExists('jobsorders');
    }
}
