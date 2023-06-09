<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'role',
    //     'password',
    //     'dob',
    //     'gender',
    //     'phone',
    //     'position_id',
    // ];

    public function designation()
    {
        return $this->belongsTo(designation::class, 'position_id',);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
    
    public function scopeUserRole(Builder $query, int $roleId)
    {
        return $query->whereHas('roles', function ($query) use ($roleId) {
            $query->where('roles.id', $roleId);
        });
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
}
