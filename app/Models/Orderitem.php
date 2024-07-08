<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'merk',
        'pk',
        'qty',
        'price',
        'disc',
        'lantai',
        'ruangan',
        'item_id',
        'branch_id_order',
    ];
}
