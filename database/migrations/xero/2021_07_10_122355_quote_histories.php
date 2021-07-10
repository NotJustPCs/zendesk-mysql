<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuoteHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_quote_histories', function (Blueprint $table) {
            $table->uuid('quote_id');
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
        Schema::dropIfExists('xero_quote_histories');
    }
}
