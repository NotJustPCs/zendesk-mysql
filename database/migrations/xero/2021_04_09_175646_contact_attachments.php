<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_contact_attachments', function (Blueprint $table) {
            $table->uuid('contact_id')->nullable();
            $table->string('attachment_id')->nullable();
            $table->string('file_name')->nullable();
            $table->string('url')->nullable();
            $table->string('mime_type')->nullable();
            $table->integer('content_length')->nullable();
            $table->boolean('include_online')->nullable();
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
