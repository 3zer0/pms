<?php

namespace App\Models;

use App\Models\Office;
use App\Models\Employee;
use App\Models\ClusterUsec;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClusterAsecs extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cluster_usec_id',
        'employee_id',
        'asec_name',
    ];

    public function cluster_usec()
    {
        return $this->belongsTo(ClusterUsec::class);
    }

    public function office()
    {
        return $this->hasOne(Office::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
