<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $primaryKey = 'idstock';
    protected $fillable = [
        'idstock',
        'product_id',
        'branch_id',
        'stock',
    ];
}
