<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'bio',
        'avatar',
        'is_active',
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
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ========== СВЯЗИ ==========

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function organization()
    {
        return $this->hasOne(Organization::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function waitingLists()
    {
        return $this->hasMany(WaitingList::class, 'client_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    // ========== ПРОВЕРКИ РОЛЕЙ ==========

    public function isAdmin(): bool
    {
        return (int)$this->role_id === 1;
    }

    public function isOrganization(): bool
    {
        return $this->role_id === 2; // Предположим, 2 — это организация
    }

    public function isClient(): bool
    {
        return $this->role_id === 3; // Предположим, 3 — это клиент
    }

    // ========== ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ ==========

    public function unreadNotificationsCount()
    {
        return $this->notifications()->where('is_read', false)->count();
    }
}
