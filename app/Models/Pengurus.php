<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengurus extends Model
{
    use HasFactory;

    protected $table = 'pengurus';

    protected $fillable = [
        'departemen_id',
        'parent_id',
        'nama',
        'jabatan',
        'tipe_jabatan',
        'foto',
        'bio',
        'email',
        'telepon',
        'periode',
        'urutan',
        'status',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Pengurus::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Pengurus::class, 'parent_id');
    }
}