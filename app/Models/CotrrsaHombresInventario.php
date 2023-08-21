<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotrrsaHombresInventario extends Model
{
    use HasFactory;

    protected $table = 'cotrrsa_hombres_inventario';

    protected $fillable = [
        'name',
        'image',
        'quantity',
        'partsAvailable',
        'supplier',
        'observations',
        'category',
    ];
}
