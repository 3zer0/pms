<?php

namespace App\Models;

use App\Models\Cluster;
use App\Models\Employee;
use App\Models\ClusterAsecs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClusterUsec extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cluster_id',
        'employee_id',
        'usec_name',
    ];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function cluster_asec()
    {
        return $this->hasMany(ClusterAsecs::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
