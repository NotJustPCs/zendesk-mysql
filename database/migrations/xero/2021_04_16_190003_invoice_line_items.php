<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoiceLineItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_invoice_line_items', function (Blueprint $table) {
            $table->uuid('invoice_id')->nullable();
            $table->uuid('line_item_id')->nullable();
            $table->string('description')->nullable();
            $table->double('quantity')->nullable();
            $table->double('unit_amount')->nullable();
            $table->string('item_code')->nullable();
            $table->string('account_code')->nullable();
            $table->string('tax_type')->nullable();
            $table->double('tax_amount')->nullable();
            $table->double('line_amount')->nullable();
            $table->double('discount_rate')->nullable();
            $table->double('discount_amount')->nullable();
            $table->string('repeating_invoice_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_invoice_line_items');
    }
}
