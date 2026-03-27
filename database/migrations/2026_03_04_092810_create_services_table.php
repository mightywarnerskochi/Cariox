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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('home_description')->nullable();
            $table->text('page_description')->nullable();
            $table->text('main_description')->nullable();

            $table->string('background_image')->nullable();
            $table->string('background_image_alt_text')->nullable();

            $table->string('main_image')->nullable();
            $table->string('main_image_alt_text')->nullable();

            $table->string('base_image1')->nullable();
            $table->string('base_image1_alt_text')->nullable();

            $table->string('base_image2')->nullable();
            $table->string('base_image2_alt_text')->nullable();

            $table->boolean('status')->default(1);
            $table->integer('position')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
