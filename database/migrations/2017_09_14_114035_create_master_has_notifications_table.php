<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterHasNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_has_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_id',false,true);
            $table->integer('notification_id',false,true);
            $table->tinyInteger('active',false,true);
            $table->timestamps();

            $table->foreign('master_id')->references('id')->on('masters')->onDelete('cascade');
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_has_notifications');
    }
}
