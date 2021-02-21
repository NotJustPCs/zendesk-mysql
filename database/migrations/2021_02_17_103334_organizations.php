<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Organizations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigInteger('id')->nullable();
            $table->string('name')->nullable();
            $table->string('details')->nullable();
            $table->string('external_id')->nullable();
            $table->bigInteger('group_id')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('shared_comments')->nullable();
            $table->boolean('shared_tickets')->nullable();
            $table->string('url')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
