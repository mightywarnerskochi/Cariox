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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('country_logo')->nullable();
            $table->string('logo_alt')->nullable();
            $table->text('address')->nullable();
            $table->text('map_link')->nullable();
            $table->string('icon')->nullable();
            $table->string('icon_alt')->nullable();
            $table->integer('order')->default(1);
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
