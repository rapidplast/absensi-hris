<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
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

    public function mesinUser()
    {
        return $this->hasMany(MesinUser::class);
    }
}
