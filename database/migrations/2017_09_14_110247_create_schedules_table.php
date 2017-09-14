<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salon_id',false,true);
            $table->integer('master_id',false,true);
            $table->time('start_time');
            $table->time('end_time');
            $table->date('day');
            $table->tinyInteger('working_status',false,true)->default(1);
            $table->timestamps();

            $table->foreign('salon_id')->references('id')->on('salons')->onDelete('cascade');
            $table->foreign('master_id')->references('id')->on('masters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
