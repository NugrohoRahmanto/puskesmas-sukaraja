<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_saran';

    protected $fillable = [
        'id_pengguna', 
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}

