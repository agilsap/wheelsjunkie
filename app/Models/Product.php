<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_id',
        'user_id',
        'product_name',
        'category',
        'weight',
        'price',
        'unit',
        'quantity',
        'condition',
        'rim_diameter',
        'front_rim_width',
        'rear_rim_width',
        'front_offset',
        'rear_offset',
        'pcd_1',
        'pcd_2',
        'tire_diameter',
        'tire_width',
        'tire_width_ratio',
        'description',
        'is_deleted',
    ];
}
