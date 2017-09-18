<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('father_name',255);
            $table->string('photo',255);
            $table->date('birthday');
            $table->string('email',255);
            $table->string('phone',255);
            $table->string('viber',255);
            $table->string('whatsapp',255);
            $table->text('address');
            $table->text('comment');
            $table->integer('user_id',false,true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masters');
    }
}
