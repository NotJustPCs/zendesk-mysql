<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Quotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_quotes', function (Blueprint $table) {
            $table->uuid('quote_id')->nullable();
            $table->uuid('contact_id')->nullable();
            $table->string('quote_number')->nullable();
            $table->string('reference')->nullable();
            $table->longText('terms')->nullable();
            $table->string('date')->nullable();
            $table->string('date_string')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('expiry_date_string')->nullable();
            $table->string('status')->nullable();
            $table->string('currency_code')->nullable();
            $table->double('currency_rate')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('total_tax')->nullable();
            $table->double('total')->nullable();
            $table->double('total_discount')->nullable();
            $table->string('title')->nullable();
            $table->string('summary')->nullable();
            $table->string('branding_theme_id')->nullable();
            $table->string('updated_date_utc')->nullable();
            $table->string('line_amount_types')->nullable();
            $table->string('status_attribute_string')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_quotes');
    }
}
