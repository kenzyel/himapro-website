<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_sections', function (Blueprint $table) {
            $table->id();

            $table->string('key', 100)->unique();       // 'hero', 'about', 'program_kerja'
            $table->string('name', 150);                 // 'Hero Section'
            $table->string('title', 255)->nullable();    // Judul section
            $table->text('subtitle')->nullable();        // Deskripsi section

            $table->json('content')->nullable();         // Semua field JSON

            $table->unsignedInteger('urutan')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_sections');
    }
};