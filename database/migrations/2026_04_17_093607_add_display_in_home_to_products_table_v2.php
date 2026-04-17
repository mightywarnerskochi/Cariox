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
        if (!Schema::hasColumn('products', 'display_in_home')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('display_in_home')->default(0)->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'display_in_home')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('display_in_home');
            });
        }
    }
};
