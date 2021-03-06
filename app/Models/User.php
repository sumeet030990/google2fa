<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User hasOne realtion with google2fa
     * 
     * @return HasOne
     */
    public function google2fa(): HasOne
    {
        return $this->hasOne('App\Models\GoogleTwoFa');
    }

    /**
     * Usre HasMany Recovery Code 
     * 
     * @return HasMany
     */
    public function recoveryCodes(): HasMany
    {
        return $this->hasMany('App\Models\RecoveryCode');
    }
}
