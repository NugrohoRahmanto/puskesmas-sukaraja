<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Information extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_informasi';

    public $incrementing = false; 
    protected $keyType = 'string';   
    
    protected static function booted()
    {
        static::creating(function ($info) {
            $info->id_informasi = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'jenis', 
        'judul', 
        'isi', 
        'cover',
    ];
}
