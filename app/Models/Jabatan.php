<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama',
        'created_at',
        'updated_at'
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
