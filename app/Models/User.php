<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'description',
        'is_active'
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
            'is_active' => 'boolean', // Permet de manipuler true/false au lieu de 1/0
        ];
    }
     public function isAdmin():bool
    {
        return $this->role === 'admin';
    }

    public function isOrganizer():bool
    {
        return $this->role === 'organizer';
    }

    public function isMember():bool
    {
        return $this->role === 'member';
    }

    public function organizedEvents()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
