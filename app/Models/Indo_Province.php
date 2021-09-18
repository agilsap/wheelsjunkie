<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indo_Province extends Model
{
    use HasFactory;
    protected $table = 'indo_province';
    protected $fillable = [
        'province',
        'city',
        'district',
        'sub_district',
        'zip_code',
    ];
}
