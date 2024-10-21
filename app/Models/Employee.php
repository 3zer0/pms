<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $connection = 'mysql_hris';

    public function items()
    {
        return $this->hasOne(Item::class);
    }

}
