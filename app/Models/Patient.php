<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($patient) {
            $patient->id_pasien = (string) Str::uuid();
        });
    }
    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'id_pengguna',
        'nama_lengkap',
        'usia',
        'jenis_kelamin',
        'no_tel',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function queues()
    {
        return $this->hasMany(Queue::class, ' id_pasien');
    }
}

