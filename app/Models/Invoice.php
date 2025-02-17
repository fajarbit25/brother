<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'to',
        'invoice_date',
        'order_id',
        'file',
        'status', 
        'total_tagihan',
        'tag_active',
        'nomor',
        'payment_method',
    ];
}
