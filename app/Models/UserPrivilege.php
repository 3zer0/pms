<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPrivilege extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'user_view',
        'user_add',
        'user_edit',
        'user_delete',
        'supplier_view',
        'supplier_add',
        'supplier_edit',
        'supplier_delete'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
