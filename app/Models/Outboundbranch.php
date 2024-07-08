<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outboundbranch extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'referensi',
        'asal',
        'tujuan',
        'product_id',
        'qty',
        'tag_temp',
        'tag_approve',
    ];
}
