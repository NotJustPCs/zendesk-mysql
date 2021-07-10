<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_contact_histories', function (Blueprint $table) {
            $table->uuid('contact_id');
            $table->text('details')->nullable();
            $table->string('changes')->nullable();
            $table->string('user')->nullable();
            $table->string('date_utc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_contact_histories');
    }
}
