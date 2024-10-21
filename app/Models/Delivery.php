<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserPrivilege;
use App\Models\UserJurisdiction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Delivery extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'ref_no',
        'supplier_id',
        'invoice_no',
        'invoice_date',
        'pojo',
        'del_quantity',
        'cluster_id',
        'office_id',
        'division_id',
        'item_count'
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
