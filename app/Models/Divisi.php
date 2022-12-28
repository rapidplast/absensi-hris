<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $table = 'divisies';
    protected $fillable = [
        'kode',
        'nama',
        'created_at',
        'updated_at'
    ];
}
