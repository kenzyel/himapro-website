<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('program_kerja_id')
                ->nullable()
                ->constrained('program_kerjas')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('judul', 255)->index();
            $table->string('slug', 255)->unique();

            $table->text('deskripsi')->nullable();
            $table->string('lokasi', 255)->nullable();

            $table->dateTime('tanggal_mulai')->index();
            $table->dateTime('tanggal_selesai')->nullable();

            $table->string('status', 30)
                ->default('planned')
                ->index();

            $table->boolean('is_public')
                ->default(true)
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};