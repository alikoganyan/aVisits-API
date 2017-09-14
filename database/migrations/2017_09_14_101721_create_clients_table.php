<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('father_name',255);
            $table->enum('sex_name',['male','female']);
            $table->date('birthday');
            $table->string('email',255);
            $table->bigInteger('card_number',false,true);
            $table->bigInteger('card_number_optional',false,true);
            $table->string('comment',255);
            $table->decimal('deposit',10,2);
            $table->decimal('bonuses',10,2);
            $table->decimal('invoice_sum',10,2);
            $table->integer('chain_id',false,true);
            $table->timestamps();

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
        Schema::dropIfExists('clients');
    }
}
