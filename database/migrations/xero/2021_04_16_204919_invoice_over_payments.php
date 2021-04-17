<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoiceOverPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_invoice_over_payments', function (Blueprint $table) {
            $table->uuid('invoice_id')->nullable();
            $table->uuid('overpayment_id')->nullable();
            $table->string('type')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('total_tax')->nullable();
            $table->double('total')->nullable();
            $table->string('updated_date_utc')->nullable();
            $table->double('currency_rate')->nullable();
            $table->double('remaining_credit')->nullable();
            $table->double('applied_amount')->nullable();
            $table->boolean('has_attachments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_sale_invoice_over_payments');
    }
}
