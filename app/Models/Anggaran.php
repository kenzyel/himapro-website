<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'departemen_id',
        'program_kerja_id',
        'nama',
        'periode',
        'jumlah',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }

    public function programKerja(): BelongsTo
    {
        return $this->belongsTo(ProgramKerja::class);
    }
}