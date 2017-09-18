<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('father_name',255);
            $table->string('photo',255);
            $table->enum('sex',['male','female']);
            $table->date('birthday');
            $table->string('email',255);
            $table->string('phone',255);
            $table->string('viber',255);
            $table->string('whatsapp',255);
            $table->text('address');
            $table->bigInteger('card_number',false,true);
            $table->bigInteger('card_number_optional',false,true);
            $table->decimal('deposit',10,2);
            $table->decimal('bonuses',10,2);
            $table->decimal('invoice_sum',10,2);
            $table->integer('position_id',false,true);
            $table->string('public_position',255);
            $table->text('comment');
            $table->integer('chain_id',false,true);
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('chain_id')->references('id')->on('chains')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
