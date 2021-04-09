<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactBrandingThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xero_contact_branding_themes', function (Blueprint $table) {
            $table->uuid('contact_id')->nullable();
            $table->string('branding_theme_id')->nullable();
            $table->string('name')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('type')->nullable();
            $table->integer('sort_order')->nullable();
            $table->string('created_date_utc')->nullable();
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
