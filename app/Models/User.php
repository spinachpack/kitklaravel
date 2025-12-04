<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_number',
        'email',
        'password',
        'first_name',
        'last_name',
        'role',
        'department',
        'profile_picture',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function approvedReservations()
    {
        return $this->hasMany(Reservation::class, 'approved_by');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDepartment()
    {
        return $this->role === 'department';
    }

    public function canManageEquipment()
    {
        return $this->role === 'admin' || $this->role === 'department';
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getProfilePictureUrlAttribute()
    {
        if (empty($this->profile_picture) || $this->profile_picture === 'default-avatar.png') {
            return asset('uploads/profiles/default-avatar.png');
        }
        return asset('uploads/profiles/' . $this->profile_picture);
    }
}