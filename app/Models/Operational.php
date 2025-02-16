<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operational extends Model
{
    use HasFactory;
    protected $fillable = [
        'trx_id',
        'tipe',
        'metode',
        'jenis',
        'branch_id',
        'approved',
        'keterangan',
        'status',
        'pesan',
        'user_id',
        'amount',
        'saldo',
        'bukti_transaksi',
        'nomor_nota',
        'status_approval',
    ];
}
