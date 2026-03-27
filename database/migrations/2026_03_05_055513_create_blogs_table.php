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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->date('date')->nullable();
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('detailed_description')->nullable();

            // Meta details
            $table->string('page_name')->nullable();
            $table->string('meta_name')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_link')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('other_meta_tags')->nullable();

            $table->integer('order')->default(0);
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
        Schema::dropIfExists('blogs');
    }
};
