<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notulensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'tanggal',
        'tempat',
        'agenda',
        'peserta',
        'isi',
        'file_path',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}