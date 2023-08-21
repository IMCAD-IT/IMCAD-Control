<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetitionHombres extends Model
{
    use HasFactory;

    protected $table = 'petition_hombres';

    protected $fillable = [
        'name',
        'quantity',
        'partsAvailable',
        'supplier',
        'observations',
        'category',
    ];
}
