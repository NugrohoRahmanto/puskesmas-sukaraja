<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->id_pengguna = (string) Str::uuid(); 
        });
    }

    protected $primaryKey = 'id_pengguna';

    protected $fillable = [
        'username', 
        'password', 
        'no_tel', 
        'status', 
        'jenis_kelamin', 
        'nama_lengkap',
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 
        'datetime',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'id_pengguna');  
    }
}
