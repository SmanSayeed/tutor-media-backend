<?php

namespace App\Models;

use App\Enums\UserRolesEnum;
use App\Enums\UserStatusEnum;
use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'password',
        'avatar',
        'role',
        'status',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatusEnum::class,
            'role' => UserRolesEnum::class,
        ];
    }

    public function sluggable(): array
    {
        return [
            'username' => [
                'source' => ['name'],
            ],
        ];
    }

    /**
     * Check if user account is active.
     */
    public function isActive(): bool
    {
        return $this->status === UserStatusEnum::ACTIVE;
    }

    public function hasVerifiedPhone(): bool
    {
        return $this->phone_verified_at instanceof Carbon;
    }

    public function markPhoneAsVerified(): void
    {
        $this->update([
            'phone_verified_at' => now(),
        ]);
    }

    /**
     * Check if user has admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRolesEnum::ADMIN;
    }

    public function isTutor(): bool
    {
        return $this->role === UserRolesEnum::TUTOR;
    }

    public function isGuardian(): bool
    {
        return $this->role === UserRolesEnum::GUARDIAN;
    }

    /**
     * Check if user account is locked.
     */
    public function isLocked(): bool
    {
        return $this->status === UserStatusEnum::BANNED;
    }

    /**
     * Increment login attempts.
     */
    public function incrementLoginAttempts(): void
    {
        $this->increment('login_attempts');
    }

    /**
     * Reset login attempts.
     */
    public function resetLoginAttempts(): void
    {
        $this->update([
            'login_attempts' => 0,
            'locked_until' => null,
            'last_login_ip' => request()->ip(),
        ]);
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
