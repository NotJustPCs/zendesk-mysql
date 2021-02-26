<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zendesk_tickets', function (Blueprint $table) {
            $table->bigInteger('id')->nullable();
            $table->boolean('allow_attachments')->nullable();
            $table->boolean('allow_channelback')->nullable();
            $table->bigInteger('assignee_id')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->string('created_at')->nullable();
            $table->longText('description')->nullable();
            $table->string('due_at')->nullable();
            $table->string('external_id')->nullable();
            $table->bigInteger('forum_topic_id')->nullable();
            $table->bigInteger('group_id')->nullable();
            $table->boolean('has_incidents')->nullable();
            $table->boolean('is_public')->nullable();
            $table->bigInteger('organization_id')->nullable();
            $table->string('priority')->nullable();
            $table->bigInteger('problem_id')->nullable();
            $table->string('raw_subject')->nullable();
            $table->string('recipient')->nullable();
            $table->bigInteger('requester_id')->nullable();
            $table->string('status')->nullable();
            $table->string('subject')->nullable();
            $table->bigInteger('submitter_id')->nullable();
            $table->string('type')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zendesk_tickets');
    }
}
