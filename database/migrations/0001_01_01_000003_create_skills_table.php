<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // Programming, Frontend, Mobile, Backend, Database, Tools
            $table->integer('proficiency')->default(80); // 1-100
            $table->string('level_label')->default('Proficient'); // Beginner, Intermediate, Proficient, Advanced
            $table->string('icon')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
