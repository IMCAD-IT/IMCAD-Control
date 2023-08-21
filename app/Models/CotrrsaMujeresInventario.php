<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotrrsaMujeresInventario extends Model
{
    use HasFactory;

    protected $table = 'cotrrsa_mujeres_inventario';

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
