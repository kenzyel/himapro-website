<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departemen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'kode',
        'deskripsi',
        'warna',
        'icon',
        'urutan',
        'status',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    /**
     * Pengurus dalam departemen ini.
     */
    public function pengurus(): HasMany
    {
        return $this->hasMany(Pengurus::class);
    }

    /**
     * Program kerja departemen ini.
     */
    public function programKerjas(): HasMany
    {
        return $this->hasMany(ProgramKerja::class);
    }

    /**
     * Anggaran departemen ini.
     */
    public function anggarans(): HasMany
    {
        return $this->hasMany(Anggaran::class);
    }

    /**
     * Transaksi keuangan departemen ini.
     */
    public function keuangans(): HasMany
    {
        return $this->hasMany(Keuangan::class);
    }
}