<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class PatientHistory extends Model
{
    use HasFactory;

    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $primaryKey = 'id_history';

    protected static function booted()
    {
        static::creating(function ($history) {
            $history->id_history = (string) Str::uuid(); 
        });
    }
    protected $table = 'history_pasien';  
    protected $fillable = [
        'nama_lengkap',
        'usia',
        'jenis_kelamin',
        'no_tel',
        'tanggal',
    ];
}

