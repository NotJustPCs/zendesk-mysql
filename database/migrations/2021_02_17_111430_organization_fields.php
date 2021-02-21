<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrganizationFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_fields', function (Blueprint $table) {
            $table->bigInteger('organization_id');
            $table->text('1password_vault_id')->nullable();
            $table->string('asset_database_company_id')->nullable();
            $table->text('gandi_tag')->nullable();
            $table->string('irregular_prepaid_hours')->nullable();
            $table->bigInteger('metis_customer_id')->nullable();
            $table->string('monthly_billing_plan')->nullable();
            $table->string('monthly_hours_warning')->nullable();
            $table->string('monthly_prepaid_hours')->nullable();
            $table->text('process_st_tag')->nullable();
            $table->longText('SN_Org_Data')->nullable();
            $table->text('time_report_link')->nullable();
            $table->text('xero_contact_id')->nullable();
            $table->text('clockify_client_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_fields');
    }
}
