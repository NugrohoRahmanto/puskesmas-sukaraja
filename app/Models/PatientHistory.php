<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class PatientHistory extends Model
{
    use HasFactory;

    protected $table = 'history_pasien';
    protected $primaryKey = 'id_history';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($history) {
            $history->id_history = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'id_pasien',
        'nik',
        'nama',
        'gender',
        'pernah_berobat',
        'tanggal',
        'no_antrian',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_pasien');
    }
}

