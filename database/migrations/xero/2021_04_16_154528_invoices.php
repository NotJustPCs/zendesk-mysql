<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Invoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_invoices', function (Blueprint $table) {
            $table->uuid('invoice_id')->nullable();
            $table->uuid('contact_id')->nullable();
            $table->string('type')->nullable();
            $table->string('date')->nullable();
            $table->string('due_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('reference')->nullable();
            $table->string('branding_theme_id')->nullable();
            $table->string('url')->nullable();
            $table->double('currency_rate')->nullable();
            $table->string('status')->nullable();
            $table->boolean('sent_to_contact')->nullable();
            $table->string('expected_payment_date')->nullable();
            $table->string('planned_payment_date')->nullable();
            $table->double('cis_deduction')->nullable();
            $table->double('cis_rate')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('total_tax')->nullable();
            $table->double('total')->nullable();
            $table->double('total_discount')->nullable();
            $table->string('repeating_invoice_id')->nullable();
            $table->boolean('has_attachments')->nullable();
            $table->boolean('is_discounted')->nullable();
            $table->double('amount_due')->nullable();
            $table->double('amount_paid')->nullable();
            $table->double('amount_credited')->nullable();
            $table->string('fully_paid_on_date')->nullable();
            $table->string('updated_date_utc')->nullable();
            $table->boolean('has_errors')->nullable();
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
        Schema::dropIfExists('xero_invoices');
    }
}
