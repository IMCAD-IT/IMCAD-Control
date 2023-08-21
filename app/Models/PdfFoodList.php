<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfFoodList extends Model
{
    use HasFactory;
    protected $table = 'pdf_save';

    protected $fillable = [
        'file',
        'comments',
        'category',
        'userType',
    ];

}
