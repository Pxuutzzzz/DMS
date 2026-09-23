<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_BIRO = 'biro';
    const ROLE_REVIEWER = 'reviewer';
    const ROLE_USER = 'user';

    const ROLES = [
        self::ROLE_SUPER_ADMIN => 'Super Admin',
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_BIRO => 'Biro',
        self::ROLE_REVIEWER => 'Reviewer',
        self::ROLE_USER => 'User',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN]);
    }

    public function isReviewer(): bool
    {
        return $this->role === self::ROLE_REVIEWER;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function canEditUploadDate(): bool
    {
        return $this->isSuperAdmin() || $this->role === self::ROLE_ADMIN;
    }

    public function canManageUsers(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_BIRO]);
    }

    public function canApproveDocuments(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_REVIEWER]);
    }

    public function canUploadDocuments(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN, self::ROLE_BIRO]);
    }

    public function canDeleteDocuments(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canManageCategories(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN, self::ROLE_BIRO]);
    }

    public function canViewAuditTrail(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN, self::ROLE_BIRO]);
    }

    public function getRoleLabelAttribute(): string
    {
        return self::ROLES[$this->role] ?? $this->role;
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'created_by');
    }

    public function approvals()
    {
        return $this->hasMany(DocumentApproval::class);
    }
}
