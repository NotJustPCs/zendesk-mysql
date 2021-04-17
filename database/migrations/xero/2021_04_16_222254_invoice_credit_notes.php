<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoiceCreditNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_invoice_credit_notes', function (Blueprint $table) {
            $table->uuid('invoice_id')->nullable();
            $table->uuid('credit_note_id')->nullable();
            $table->string('type')->nullable();
            $table->string('date')->nullable();
            $table->string('due_date')->nullable();
            $table->string('status')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('total_tax')->nullable();
            $table->double('total')->nullable();
            $table->double('cis_deduction')->nullable();
            $table->double('cis_rate')->nullable();
            $table->string('updated_date_utc')->nullable();
            $table->string('fully_paid_on_date')->nullable();
            $table->string('credit_note_number')->nullable();
            $table->string('reference')->nullable();
            $table->boolean('sent_to_contact')->nullable();
            $table->double('currency_rate')->nullable();
            $table->double('remaining_credit')->nullable();
            $table->double('applied_amount')->nullable();
            $table->string('branding_theme_id')->nullable();
            $table->string('status_attribute_string')->nullable();
            $table->boolean('has_attachments')->nullable();
            $table->boolean('has_errors')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_sale_invoice_credit_notes');
    }
}
