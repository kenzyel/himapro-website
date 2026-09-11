<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'role_id',
    'name',
    'email',
    'password',
    'avatar',
    'status',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Role yang dimiliki user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

        /**
     * Mengecek apakah user memiliki role tertentu.
     */
    public function hasRole(string|array $roles): bool
    {
        $roleSlug = $this->role?->slug;

        if (! $roleSlug) {
            return false;
        }

        if (is_string($roles)) {
            return $roleSlug === $roles;
        }

        return in_array($roleSlug, $roles, true);
    }

    /**
     * Mengecek apakah user memiliki permission tertentu.
     */
    public function hasPermission(string $permission): bool
    {
        if (! $this->role) {
            return false;
        }

        if (! $this->role->is_active) {
            return false;
        }

        return $this->role
            ->permissions()
            ->where('slug', $permission)
            ->exists();
    }

    /**
     * Mengecek apakah user memiliki salah satu permission.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mengecek apakah user memiliki seluruh permission.
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (! $this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}