<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'delivery_id';
    protected $fillable = [
        'transaction_id',
        'courier_name',
        'delivery_cost',
        'receipt_number',
        'delivery_date',
        'delivered_date',
        'status'
    ];
}
