<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'reservasi_id',
        'reservasi_date',
        'reservasi_approved',
        'reservasi_received',
        'teknisi_id',
        'product_user_id',
    ];
}
