<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'tanggal_order',
        'costumer_id',
        'total_unit',
        'progres',
        'status',
        'invoice_id',
        'status_invoice',
        'tag_invoice',
        'total_price',
        'discount',
        'nomor_nota',
        'nota',
        'teknisi',
        'helper',
        'jadwal',
        'request_jam',
        'branch_id',
        'keterangan',
        'payment',
        'due_date',
        'ppn',
];
}
