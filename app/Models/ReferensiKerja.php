<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferensiKerja extends Model
{
    use HasFactory;
    protected $table = 'referensikerjas';
    protected $fillable = [
        'kode',
        'nama',
        'workin',
        'restout',
        'restin',
        'workout',
        'total_jam',
        'rangerestout',
        'rangerestin',
        'created_at',
        'updated_at'
    ];
}
