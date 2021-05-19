<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RepeatingInvoiceSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_repeating_invoice_schedules', function (Blueprint $table) {
            $table->uuid('invoice_id');
            $table->bigInteger('period')->nullable();
            $table->string('unit')->nullable();
            $table->bigInteger('due_date')->nullable();
            $table->string('due_date_type')->nullable();
            $table->string('start_date')->nullable();
            $table->string('next_scheduled_date')->nullable();
            $table->string('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_repeating_invoice_schedules');
    }
}
