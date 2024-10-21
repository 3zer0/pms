<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuthenticate extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'user_uniq_id',
        'token',
        'code',
        'expired_at',
        'created_at'
    ];
}
