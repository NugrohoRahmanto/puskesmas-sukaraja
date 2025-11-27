<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->id_pengguna)) {
                $user->id_pengguna = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'username',
        'email',
        'nama_lengkap',
        'no_tel',
        'status',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'id_pengguna');
    }
}
