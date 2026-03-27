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
        Schema::create('home_banner_contents', function (Blueprint $table) {
            $table->id();
            $table->string('small_title')->nullable();
            $table->string('main_title')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('trusted_clients_count')->nullable();
            $table->string('trusted_clients_label')->nullable();
            $table->string('rating_label')->nullable();
            $table->decimal('google_rating', 3, 1)->nullable();
            $table->string('review_label')->nullable();
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
        Schema::dropIfExists('home_banner_contents');
    }
};
