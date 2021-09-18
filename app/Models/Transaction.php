<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'transaction_id';
    protected $fillable =[
        'buyer_user_id',
        'seller_user_id',
        'admin_id',
        'payment_status',
        'payment_date',
        'bank_account_owner',
        'proof_of_payment',
        'transaction_detail_id',
        'transaction_total_cost',
        'transaction_status',
        'additional_info',
    ];
}
