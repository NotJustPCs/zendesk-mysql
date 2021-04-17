<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_contacts', function (Blueprint $table) {
            $table->uuid('contact_id');
            $table->string('contact_number')->nullable();
            $table->string('account_number')->nullable();
            $table->string('contact_status')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email_address')->nullable();
            $table->string('skype_user_name')->nullable();
            $table->string('bank_account_details')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('accounts_receivable_tax_type')->nullable();
            $table->string('accounts_payable_tax_type')->nullable();
            $table->boolean('is_supplier')->nullable();
            $table->boolean('is_customer')->nullable();
            $table->string('xero_network_key')->nullable();
            $table->string('sales_default_account_code')->nullable();
            $table->string('purchases_default_account_code')->nullable();
            $table->string('tracking_category_name')->nullable();
            $table->string('tracking_category_option')->nullable();
            $table->string('updated_date_utc')->nullable();
            $table->string('website')->nullable();
            $table->double('discount', 8, 2)->nullable();
            $table->boolean('has_attachments')->nullable();
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
        Schema::dropIfExists('xero_contacts');
    }
}
