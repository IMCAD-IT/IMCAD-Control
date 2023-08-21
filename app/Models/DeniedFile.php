<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeniedFile extends Model
{
    use HasFactory;
    protected $table = 'denied_files';

    protected $fillable = [
        'file',
        'comments',
        'category',
        'userType',
        'reasons',
    ];
}
