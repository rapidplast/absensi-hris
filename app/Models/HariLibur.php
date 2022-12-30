<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    use HasFactory;
    protected $table = 'hariliburs';
    protected $fillable = [
        'tanggalStart',
        'tanggalEnd',
        'plant',
        'keterangan',
        'created_at',
        'updated_at'
    ];
}
