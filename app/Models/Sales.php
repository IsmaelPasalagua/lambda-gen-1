<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'payment_method_id',
        'total_price',
        'subtotal_price',
        'date',
    ];

    protected $table = 'sales';
}
