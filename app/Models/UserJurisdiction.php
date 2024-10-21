<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserJurisdiction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'cluster_id',
        'office_id',
        'division_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
