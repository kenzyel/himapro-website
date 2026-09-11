<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'subjek',
        'pesan',
        'status',
        'dibaca_at',
        'dibalas_at',
    ];

    protected $casts = [
        'dibaca_at' => 'datetime',
        'dibalas_at' => 'datetime',
    ];
}