<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    use HasFactory;
    protected $primaryKey = 'idcostumer';
    protected $fillable = [
        'costumer_kode',
        'costumer_name',
        'costumer_pic',
        'costumer_phone',
        'costumer_email',
        'costumer_address',
        'costumer_status',
        'jumlah_order',
        'branch_id',
    ];
}
