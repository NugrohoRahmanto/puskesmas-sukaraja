<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


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

    protected $appends = ['cover_url'];

    public function getCoverUrlAttribute(): ?string
    {
        if (!$this->cover) {
            return null;
        }

        if (filter_var($this->cover, FILTER_VALIDATE_URL)) {
            return $this->cover;
        }

        $cover = ltrim($this->cover, '/');
        if (Str::startsWith($cover, 'storage/')) {
            $cover = Str::after($cover, 'storage/');
        }
        if (Str::startsWith($cover, 'public/')) {
            $cover = Str::after($cover, 'public/');
        }
        if (Str::startsWith($cover, 'covers/')) {
            $cover = Str::after($cover, 'covers/');
        }

        if (Storage::disk('public')->exists('covers/' . $cover)) {
            return asset('storage/covers/' . $cover);
        }

        // Fallback to asset helper for already-public paths
        return asset(trim($this->cover, '/'));
    }
}
