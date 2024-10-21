<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserPrivilege;
use App\Models\UserJurisdiction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'uniq_id',
        'firstname',
        'lastname',
        'designate',
        'email',
        'mobile_no',
        'username',
        'password',
        'first_login',
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
        ];
    }

    public function privilege()
    {
        return $this->hasOne(UserPrivilege::class);
    }

    public function jurisdiction()
    {
        return $this->hasOne(UserJurisdiction::class);
    }
}
