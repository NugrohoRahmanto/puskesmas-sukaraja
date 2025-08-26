<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_antrian';

    protected $fillable = [
        'id_pasien',  
        'no_antrian',
        'created_at',
        'updated_at',
        'tanggal',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_pasien');
    }

    public function user()
    {
        return $this->belongsToThrough(User::class, Patient::class);
    }
}
