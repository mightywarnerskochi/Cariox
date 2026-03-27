<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('official_email')->nullable();

            $table->string('logo')->nullable();
            $table->string('logo_alt_text')->nullable();

            $table->string('footer_logo')->nullable();
            $table->string('footer_logo_alt_text')->nullable();
            $table->text('footer_logo_description')->nullable();

            $table->string('favicon')->nullable();

            $table->longText('terms_conditions')->nullable();
            $table->longText('privacy_policy')->nullable();

            // Social Media links
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('pinterest_link')->nullable();
            $table->string('youtube_link')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
