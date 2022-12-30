<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'mesin_id',
        'status_absen',
        'created_at',
        'updated_at'
    ];
}
