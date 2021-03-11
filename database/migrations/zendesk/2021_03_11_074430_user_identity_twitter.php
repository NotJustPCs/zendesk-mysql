<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserIdentityTwitter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zendesk_user_identity_twitter', function (Blueprint $table) {
            $table->bigInteger('id')->nullable();
            $table->bigInteger('user_id');
            $table->string('created_at')->nullable();
            $table->string('deliverable_state')->nullable();
            $table->boolean('primary')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('undeliverable_count')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('url')->nullable();
            $table->string('value')->nullable();
            $table->boolean('verified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zendesk_user_identity_twitter');
    }
}
