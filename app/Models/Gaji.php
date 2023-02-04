<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'gaji';
    protected $fillable = [
        'pid',
        'check_in',
        'check_out',
        'divisi_id',
        'date',
        'telat',
        'jam_kerja',
        'jum_hari',
        'lembur_aw',
        'lembur_ak',
        'tot_lembur',
        'upah',
        'total_upah',
        'ket',
        'created_at',
        'updated_at'
    ];
}
