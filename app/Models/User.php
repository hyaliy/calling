<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property-read PhoneCall $phoneCalls
 * @property-read PhoneCall $phoneReceives
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return HasMany<PhoneCall>
     */
    public function phoneCalls(): HasMany
    {
        return $this->hasMany(PhoneCall::class, 'caller_user_id');
    }

    /**
     * @return HasMany<PhoneCall>
     */
    public function phoneReceives(): HasMany
    {
        return $this->hasMany(PhoneCall::class, 'receiver_user_id');
    }
}
