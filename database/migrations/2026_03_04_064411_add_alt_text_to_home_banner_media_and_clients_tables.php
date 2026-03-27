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
        Schema::table('home_banner_media', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('file_path');
        });

        Schema::table('trusted_clients', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('client_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_banner_media', function (Blueprint $table) {
            $table->dropColumn('alt_text');
        });

        Schema::table('trusted_clients', function (Blueprint $table) {
            $table->dropColumn('alt_text');
        });
    }
};
