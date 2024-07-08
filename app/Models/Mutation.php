<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'tanggal_mutasi',
        'jenis',
        'order_id',
        'reservasi_id',
        'penerima',
        'qty',
        'saldo_awal',
        'saldo_akhir',
        'branch_id',
    ];
}
