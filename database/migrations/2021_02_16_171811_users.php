<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id')->nullable();
            $table->string('alias')->nullable()->nullable();
            $table->boolean('active')->nullable()->nullable();
            $table->boolean('chat_only')->nullable()->nullable();
            $table->string('created_at')->nullable()->nullable();
            $table->integer('custom_role_id')->nullable()->nullable();
            $table->bigInteger('default_group_id')->nullable()->nullable();
            $table->string('details')->nullable()->nullable();
            $table->string('email')->nullable()->nullable();
            $table->string('external_id')->nullable();
            $table->string('iana_time_zone')->nullable();
            $table->string('last_login_at')->nullable();
            $table->string('locale')->nullable();
            $table->string('locale_id')->nullable();
            $table->boolean('moderator')->nullable();
            $table->string('name')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('only_private_comments')->nullable();
            $table->bigInteger('organization_id')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('report_csv')->nullable();
            $table->boolean('restricted_agent')->nullable();
            $table->string('role')->nullable();
            $table->integer('role_type')->nullable();
            $table->boolean('shared')->nullable();
            $table->boolean('shared_agent')->nullable();
            $table->boolean('shared_phone_number')->nullable();
            $table->string('signature')->nullable();
            $table->boolean('suspended')->nullable();
            $table->string('ticket_restriction')->nullable();
            $table->string('time_zone')->nullable();
            $table->boolean('two_factor_auth_enabled')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('url')->nullable();
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
        //
    }
}
