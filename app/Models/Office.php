<?php

namespace App\Models;

use App\Models\ClusterAsecs;
use App\Models\UserJurisdiction;
use App\Models\EmployeeJurisdiction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'cluster_asec_id',
        'office_name',
        'abbre',
        'employee_id',
        'director_name',
    ];

    public function cluster_asec()
    {
        return $this->belongsTo(ClusterAsecs::class);
    }

    public function jurisdiction()
    {
        return $this->hasOne(UserJurisdiction::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }


}
