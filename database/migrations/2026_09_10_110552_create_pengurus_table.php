<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengurus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('departemen_id')
                ->nullable()
                ->constrained('departemens')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('pengurus')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->string('nama', 255)->index();
            $table->string('jabatan', 150)->index();
            $table->string('tipe_jabatan', 50)->index();

            $table->string('foto', 255)->nullable();
            $table->text('bio')->nullable();

            $table->string('email', 255)->nullable();
            $table->string('telepon', 50)->nullable();

            $table->string('periode', 20)->index();

            $table->unsignedInteger('urutan')->index();

            $table->string('status', 30)
                ->default('active')
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengurus');
    }
};