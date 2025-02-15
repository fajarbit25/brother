<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingArusKhas extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_id',
        'tanggal',
        'nota',
        'costumer',
        'items',
        'qty',
        'payment_method',
        'payment_type',
        'amount',
        'akun_id', //from ops item table
        'klasifikasi',
        'petty_cash',
        'saldo',
    ];
}
