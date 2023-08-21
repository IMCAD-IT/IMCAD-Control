<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetitionMujeres extends Model
{
    use HasFactory;

    protected $table = 'petition_mujeres';

    protected $fillable = [
        'name',
        'quantity',
        'partsAvailable',
        'supplier',
        'observations',
        'category',
    ];
}
