<?php

namespace App\Models;

use App\Models\Office;
use App\Models\Employee;
use App\Models\EmployeeJurisdiction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'office_id',
        'division_name',
        'abbre',
        'employee_id',
        'division_head',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function jurisdiction()
    {
        return $this->hasOne(EmployeeJurisdiction::class);
    }
}
