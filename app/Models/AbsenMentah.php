<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenMentah extends Model
{
    use HasFactory;
    protected $fillable = [
        'pid',
        'status',
        'date',
        'created_at',
        'updated_at'
    ];
}
