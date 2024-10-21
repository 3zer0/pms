<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Employee;
use App\Models\UserPrivilege;
use App\Models\UserJurisdiction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Item extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'delivery_id',
        'article_id',
        'category_id',
        // 'item_quantity',
        'unit_of_measure',
        'description',
        'purchase_price',
        'property_no',
        'serial_no',
        'accountability_type',
        'accountability_no',
        'mr_to',
        'ass_to',
        'status',
        'invoice_date',
        'created_by'
    ];

    public function privilege()
    {
        return $this->hasOne(UserPrivilege::class);
    }

    public function jurisdiction()
    {
        return $this->hasOne(UserJurisdiction::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'mr_to');
    }
}
