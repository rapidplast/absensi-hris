<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftKerja extends Model
{
    use HasFactory;
    protected $table = 'shift_kerjas';
    protected $fillable = [
        'nama',
        'jam_mulai',
        'jam_selesai',
        'created_at',
        'updated_at'
    ];
}
