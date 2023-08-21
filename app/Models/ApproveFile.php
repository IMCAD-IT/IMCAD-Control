<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproveFile extends Model
{
    use HasFactory;

    protected $table = 'approve_files';

    protected $fillable = [
        'file',
        'comments',
        'category',
        'userType',
        'reasons',
    ];
}
