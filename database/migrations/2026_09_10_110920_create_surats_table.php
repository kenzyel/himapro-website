<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('jenis', 30)->index();

            $table->string('nomor_surat', 150)->unique();

            $table->date('tanggal_surat')->index();
            $table->date('tanggal_terima')->nullable();

            $table->string('pengirim', 255)->nullable();
            $table->string('penerima', 255)->nullable();

            $table->string('perihal', 255)->index();

            $table->string('file_path', 500)->nullable();

            $table->string('status', 30)
                ->default('draft')
                ->index();

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};