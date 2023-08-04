<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
// use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Laravel\Sanctum\Contracts\HasApiTokens as HasApiTokensContract;

class User extends Authenticatable implements HasApiTokensContract
{
    use HasApiTokens, HasFactory, Notifiable, UsesLandlordConnection, HasUuids;
    // UsesTenantConnection
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // tables becomes admins for admin app.
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'company_id',
        'password',
    ];

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
