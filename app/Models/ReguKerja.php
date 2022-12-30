<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReguKerja extends Model
{
    use HasFactory;
    protected $table = 'regukerjas';
    protected $fillable = [
        'kode',
        'nama',
        'tgl_start',
        'hari',
        'jadwal',
        'created_at',
        'updated_at'
    ];
}
