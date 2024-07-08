<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'idbranch',
        'id_office',
        'branch_name',
        'branch_address',
        'owner',
        'manager_area',
    ];
}
