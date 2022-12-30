<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $table = 'cuties';

    protected $fillable = [
        'id',
        'pegawai_id',
        'keterangan',
        'tanggal_cuti',
        'status',
        'created_at',
        'updated_at'
    ];
}
