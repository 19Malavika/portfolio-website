<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('tagline')->nullable();
            $table->text('short_intro');
            $table->text('career_objective')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('location')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('resume_path')->nullable();
            $table->json('strengths')->nullable();
            $table->json('interests')->nullable();
            $table->json('stats')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
