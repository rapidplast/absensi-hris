<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alasan extends Model
{
    use HasFactory;

    protected $table = 'alasans';
    protected $fillable = [
        'kode',
        'nama',
        'cuti',
        'rot',
        'tunha',
        'created_at',
        'updated_at'
    ];
}
