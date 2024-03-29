<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user',
        'name',
        'phone',
        'email',
        'password',
        'access_level',
        'property_code',
        'banned',
        'status',
    ];
    public function department()
    {
        return $this->hasOne(Department::class); // Assuming the foreign key is 'user_id'
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'user_properties');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
    public function departaments()
    {
        return $this->hasMany(Departament::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

}
