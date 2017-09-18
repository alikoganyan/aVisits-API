<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalonHasEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salon_has_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salon_id',false,true);
            $table->integer('employee_id',false,true);
            $table->integer('position_id',false,true);
            $table->string('public_position',255);
            $table->timestamps();

            $table->foreign('salon_id')->references('id')->on('salons')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salon_has_employees');
    }
}
