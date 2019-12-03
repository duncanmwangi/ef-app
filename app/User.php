<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function isAdmin()
    {
        return $this->role=='admin';
    }

    public function isRegionalFundManager()
    {
        return $this->role=='regional-fund-manager';
    }

    public function isFundManager()
    {
        return $this->role=='fund-manager';
    }

    public function isInvestor()
    {
        return $this->role=='investor';
    }
    public function getNameAttribute()
    {
        return "{$this->firstName} {$this->lastName}";
    }
    public function getRoleNameAttribute()
    {
        return ucwords(str_ireplace('-', ' ', $this->role));
    }

}
