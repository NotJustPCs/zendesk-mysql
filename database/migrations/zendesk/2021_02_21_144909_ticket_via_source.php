<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TicketViaSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zendesk_ticket_via_source', function (Blueprint $table) {
            $table->bigInteger('ticket_id');
            $table->string('from_address')->nullable();
            $table->string('from_name')->nullable();
            $table->string('to_address')->nullable();
            $table->string('to_name')->nullable();
            $table->string('rel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zendesk_ticket_via_source');
    }
}
