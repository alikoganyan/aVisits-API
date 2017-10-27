<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('sex');
            $table->dropColumn('card_number');
            $table->dropColumn('card_number_optional');
            $table->dropColumn('deposit');
            $table->dropColumn('bonuses');
            $table->dropColumn('invoice_sum');
            $table->dropColumn('position_id');
            $table->dropColumn('public_position');
            $table->dropColumn('phone_2');
            $table->dropColumn('employment_date');
            $table->dropColumn('dismissed');
            $table->dropColumn('dismissed_date');
            $table->dropColumn('displayed_in_records');
            $table->dropColumn('available_for_online_recording');
            $table->dropColumn('access_profile_id');
            $table->dropForeign('employees_position_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
}
