<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $primaryKey = 'diproduct';
    protected $fillable = [
        'product_code',
        'cat',
        'product_name',
        'satuan',
        'supplier_id',
        'harga_beli',
        'harga_jual',
    ];
}
