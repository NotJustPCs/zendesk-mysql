<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemSaleDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_item_sale_details', function (Blueprint $table) {
            $table->uuid('item_id')->nullable();
            $table->double('unit_price')->nullable();
            $table->string('account_code')->nullable();
            $table->string('cogs_account_code')->nullable();
            $table->string('tax_type')->nullable();
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
