<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_name',
        'price',
        'food_img',
        'v_id',
        'v_name',
        'status',
    ];
}
