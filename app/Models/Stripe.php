<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stripe extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'product_name',
        'quantity',
        'price',
        'currency',
        'customer_name',
        'customer_email',
        'payment_status',
        'customer_method'
    ];
}
