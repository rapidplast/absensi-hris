<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesinUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'ip',
        'password',
        'is_default',
        'created_at',
        'updated_at'
    ];

    public function Mesin()
    {
        return $this->hasMany(Mesin::class);
    }
}
