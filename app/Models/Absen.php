<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $connection = 'absensi_frbackup';
    protected $fillable = [
        'pid',
        'check_in',
        'check_out',
        'telat',
        'check_in1',
        'check_out1',
        'check_in2',
        'check_out2',
        'check_in3',
        'check_out3',
        'created_at',
        'updated_at'
    ];
}
