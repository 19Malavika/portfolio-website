<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // Full Stack, Mobile (Flutter), Frontend, etc.
            $table->text('short_description');
            $table->longText('full_description')->nullable();
            $table->text('problem_statement')->nullable();
            $table->json('features')->nullable();
            $table->json('technologies')->nullable();
            $table->json('highlights')->nullable();
            $table->string('image_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('live_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

