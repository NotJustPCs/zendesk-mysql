<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactPurchaseTrackingCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_contact_purchase_tracking_categories', function (Blueprint $table) {
            $table->uuid('contact_id')->nullable();
            $table->string('tracking_category_name')->nullable();
            $table->string('tracking_option_name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
