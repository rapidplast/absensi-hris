<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ===== Check Image ===== //
    public function getImage(){
        if(!$this->image || $this->image == null){
            return asset('backend/images/default.png');
        }else{
            return asset('backend/images/'.$this->image);
        }
    }
    // ===== Check Image ===== //
    
    
    // ===== Check Role ===== //
    public function getUserRole()
    {
        return $this->role()->getResults();
    }

    public function checkRole($role)
    {
        return (strtolower($role) == strtolower($this->have_role->role)) ? true : false;
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();

        if(is_array($roles)){
            foreach($roles as $need_role){
                if($this->checkRole($need_role)){
                    return true;
                }
            }
        }else{
            return $this->checkRole($roles);
        }
        return false;
    }
    // ===== Check Role ===== //



    // ===== Relationship ===== //
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    // ===== Relationship ===== //
}
