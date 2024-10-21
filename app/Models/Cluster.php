<?php

namespace App\Models;

use App\Models\ClusterUsec;
use App\Models\EmployeeJurisdiction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cluster extends Model
{
    use HasFactory;

    // public function cluster_usec() {
    //     return $this->hasOne(ClusterUsec::class);
    // }

    // public function jurisdiction()
    // {
    //     return $this->hasOne(EmployeeJurisdiction::class);
    // }
}
