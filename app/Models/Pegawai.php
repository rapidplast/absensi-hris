<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'jabatan_id',
        'departement_id',
        'divisi_id',
        'regukerja_id',
        'pid',
        'nama',
        'email',
        'no_ktp',
        'alamat',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
