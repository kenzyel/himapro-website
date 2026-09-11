<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'title',
        'subtitle',
        'content',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Ambil section by key.
     */
    public static function get(string $key): ?self
    {
        return static::where('key', $key)->first();
    }

    /**
     * Ambil semua section aktif, terurut.
     */
    public static function getActive()
    {
        return static::where('is_active', true)
            ->orderBy('urutan')
            ->get();
    }
}