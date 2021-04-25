<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TimeSheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_timesheets', function (Blueprint $table) {
            $table->uuid('timesheet_id')->nullable();
            $table->uuid('payroll_calendar_id')->nullable();
            $table->uuid('employee_id')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('status')->nullable();
            $table->double('total_hours')->nullable();
            $table->string('updated_date_utc')->nullable();
            $table->string('timesheet_lines')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xero_timesheets');
    }
}
