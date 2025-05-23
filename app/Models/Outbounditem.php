<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbounditem extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservasi_date',
        'outbound_id',
        'order_id',
        'product_id',
        'qty',
        'material_price',
        'sub_total',
        'teknisi',
        'temp_status',
        'item_id',
    ];
}
