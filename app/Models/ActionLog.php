<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class ActionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'quantity',
        'inventario',
        'details',
        'details_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}