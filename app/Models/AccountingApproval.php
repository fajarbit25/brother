<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingApproval extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch',
        'segment',
        'referensi_id',
        'tanggal',
        'tipe',
        'payment_method',
        'amount',
        'akun_id',
    ];
}
