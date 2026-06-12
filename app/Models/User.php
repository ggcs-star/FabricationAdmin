<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasRoles; // Added standard traits

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Remove $guard_name = 'web'; to let Spatie dynamically detect guard

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Helpful for frontend to instantly know the role without an extra API call
        return [
            'roles' => $this->getRoleNames()
        ];
    }

    public function vendor()
{
    return $this->hasOne(Vendor::class);
}
}