<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingSaldo extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_id',
        'petty_cash',
        'saldo_akhir',
        'updated_by',
    ];
}
