<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departemens', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 150);
            $table->string('slug', 150)->unique();
            $table->string('kode', 30)->nullable()->unique();

            $table->text('deskripsi')->nullable();

            $table->string('warna', 20)->nullable();
            $table->string('icon', 100)->nullable();

            $table->unsignedInteger('urutan')->index();

            $table->string('status', 30)
                ->default('active')
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departemens');
    }
};