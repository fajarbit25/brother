<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbounditem extends Model
{
    use HasFactory;
    protected $fillable = [
        'inbound_id',
        'product_id',
        'qty',
        'price',
        'jumlah',
    ];
}
