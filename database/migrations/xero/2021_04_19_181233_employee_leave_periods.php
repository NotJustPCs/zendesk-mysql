<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeLeavePeriods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_employee_leave_periods', function (Blueprint $table) {
            $table->uuid('leave_id')->nullable();
            $table->string('period_start_date')->nullable();
            $table->string('period_end_date')->nullable();
            $table->string('number_of_units')->nullable();
            $table->string('period_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_employee_leave_periods');
    }
}
