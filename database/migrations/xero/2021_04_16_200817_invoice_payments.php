<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoicePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_invoice_payments', function (Blueprint $table) {
            $table->uuid('payment_id')->nullable();
            $table->uuid('invoice_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('credit_note_number')->nullable();
            $table->string('code')->nullable();
            $table->string('date')->nullable();
            $table->double('currency_rate')->nullable();
            $table->double('amount')->nullable();
            $table->string('reference')->nullable();
            $table->boolean('is_reconciled')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('updated_date_utc')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('particulars')->nullable();
            $table->string('details')->nullable();
            $table->boolean('has_account')->nullable();
            $table->boolean('has_validation_errors')->nullable();
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
        Schema::dropIfExists('xero_invoice_payments');
    }
}
