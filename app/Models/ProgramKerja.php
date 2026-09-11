<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramKerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'departemen_id',
        'nama',
        'slug',
        'deskripsi',
        'tujuan',
        'target',
        'periode',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'anggaran',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'anggaran' => 'decimal:2',
    ];

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class);
    }

    public function anggarans(): HasMany
    {
        return $this->hasMany(Anggaran::class);
    }

    public function keuangans(): HasMany
    {
        return $this->hasMany(Keuangan::class);
    }
}