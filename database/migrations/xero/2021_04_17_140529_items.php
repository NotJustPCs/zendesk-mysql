<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_items', function (Blueprint $table) {
            $table->uuid('item_id')->nullable();
            $table->string('code')->nullable();
            $table->string('inventory_asset_account_code')->nullable();
            $table->string('name')->nullable();
            $table->boolean('is_sold')->nullable();
            $table->boolean('is_purchased')->nullable();
            $table->string('description')->nullable();
            $table->string('purchase_description')->nullable();
            $table->boolean('is_tracked_as_inventory')->nullable();
            $table->double('total_cost_pool')->nullable();
            $table->double('quantity_on_hand')->nullable();
            $table->string('updated_date_utc')->nullable();
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
        Schema::dropIfExists('xero_items');
    }
}
