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
        Schema::create('choose_us_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('choose_id')->nullable()->constrained('choose_us')->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->string('text')->nullable();
            $table->integer('order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choose_us_items');
    }
};
