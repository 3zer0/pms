<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ptr extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'ref_no',
        'transfer_type',
        'rec_by',
        'trans_reason',
        'office_id',
        'division_id',
        'ppe_condition'
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
