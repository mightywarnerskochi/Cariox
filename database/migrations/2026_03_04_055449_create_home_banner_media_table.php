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
        Schema::create('home_banner_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_banner_content_id')->constrained('home_banner_contents')->cascadeOnDelete();
            $table->string('type')->nullable(); // image or video maybe
            $table->string('file_path')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_banner_media');
    }
};
