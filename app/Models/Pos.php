<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    use HasFactory;
    protected $fillable = [
       'branch_id',
       'id_transaksi',
       'product_id',
        'qty',
        'price',
        'total_price',
       'temp_status',
       'idcostumer',
       'payment_status',
       'user_id',
    ];
}
