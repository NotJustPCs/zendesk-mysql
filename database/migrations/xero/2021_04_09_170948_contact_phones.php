<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactPhones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_contact_phones', function (Blueprint $table) {
            $table->uuid('contact_id')->nullable();
            $table->string('phone_type')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_area_code')->nullable();
            $table->string('phone_country_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
