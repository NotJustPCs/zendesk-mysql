<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RepeatingInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_repeating_invoices', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('type');
            $table->uuid('contact_id')->nullable();
            $table->uuid('repeating_invoice_id')->nullable();
            $table->string('line_amount_types')->nullable();
            $table->string('reference')->nullable();
            $table->string('branding_theme_id')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('status')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('total_tax')->nullable();
            $table->double('total')->nullable();
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
        Schema::dropIfExists('xero_repeating_invoices');
    }
}
