<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodListPetition extends Model
{
    use HasFactory;

    protected $table = 'food_list_petition';

    protected $fillable = [
        'name',
        'quantity',
        'partsAvailable',
        'supplier',
        'observations',
        'category',
    ];
}
