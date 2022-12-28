<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariKerja extends Model
{
    use HasFactory;
    protected $table = 'hari_kerjas';
    protected $fillable = [
        'pid',
        'hari',
        'shift_id',
        'created_at',
        'updated_at'
    ];
}
