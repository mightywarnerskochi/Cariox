<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('official_phone')->nullable()->after('company_name');
            $table->string('official_whatsapp')->nullable()->after('official_phone');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('official_whatsapp');
            $table->dropColumn('official_phone');
        });
    }
};

