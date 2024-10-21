<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_code',
        'type'
    ];

    public function privilege()
    {
        return $this->hasOne(UserPrivilege::class);
    }

    public function jurisdiction()
    {
        return $this->hasOne(UserJurisdiction::class);
    }
}
