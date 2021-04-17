<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoiceLineItemTrackings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_invoice_line_item_trackings', function (Blueprint $table) {
            $table->uuid('line_item_id')->nullable();
            $table->uuid('tracking_category_id')->nullable();
            $table->uuid('tracking_option_id')->nullable();
            $table->string('name')->nullable();
            $table->string('option')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_invoice_line_item_trackings');
    }
}
