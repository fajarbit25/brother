<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productuser extends Model
{
    use HasFactory;
    protected $fillable = [
        'teknisi_id',
        'reservasi_id',
        'produk_id',
        'qty_awal',
        'qty',
        'retur',
    ];
}
