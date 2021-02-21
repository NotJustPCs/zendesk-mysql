<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_fields', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->string('asset_database_user_id')->nullable();
            $table->string('irregular_prepaid_hours')->nullable();
            $table->longText('SN_User_Data')->nullable();
            $table->text('xero_contact_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_fields');
    }
}
