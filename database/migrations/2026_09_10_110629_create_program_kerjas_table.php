<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_kerjas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('departemen_id')
                ->nullable()
                ->constrained('departemens')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('nama', 255)->index();
            $table->string('slug', 255)->unique();

            $table->text('deskripsi')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('target')->nullable();

            $table->string('periode', 20)->index();
            $table->string('status', 30)
                ->default('draft')
                ->index();

            $table->date('tanggal_mulai')->nullable()->index();
            $table->date('tanggal_selesai')->nullable()->index();

            $table->decimal('anggaran', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_kerjas');
    }
};