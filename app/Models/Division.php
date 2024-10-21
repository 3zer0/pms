<?php

namespace App\Models;

use App\Models\Office;
use App\Models\ClusterAsecs;
use App\Models\UserJurisdiction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'division_name',
        'employee_id',
        'division_head'
    ];

    public function jurisdiction()
    {
        return $this->hasMany(UserJurisdiction::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
