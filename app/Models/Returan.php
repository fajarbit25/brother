<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returan extends Model
{
    use HasFactory;
    protected $fillable = [
        'teknisi_id',
        'product_id',
        'tanggal',
        'qty',
        'tag_approved',
        'branch_id',
    ];
}
