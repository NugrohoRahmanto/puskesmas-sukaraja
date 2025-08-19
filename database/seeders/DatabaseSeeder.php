<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Information;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan admin
        User::create([
            'username' => 'admin',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
            'no_tel' => '081234567890',
            'jenis_kelamin' => 'L',
            'nama_lengkap' => 'Admin Puskesmas',
        ]);

        // Menambahkan user biasa
        User::create([
            'username' => 'user1',
            'password' => bcrypt('12345678'),
            'role' => 'user',
            'no_tel' => '081234567891',
            'jenis_kelamin' => 'P',
            'nama_lengkap' => 'User Satu',
        ]);

        // Menambahkan informasi
        Information::create([
            'jenis' => 'Berita',
            'judul' => 'Puskesmas Sukaraja Membuka Layanan Baru',
            'isi' => 'Kami dengan bangga mengumumkan bahwa kami kini membuka layanan baru untuk pemeriksaan kesehatan lebih cepat.',
            'cover' => 'cover_image_1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Information::create([
            'jenis' => 'Pengumuman',
            'judul' => 'Jam Layanan Puskesmas',
            'isi' => 'Puskesmas Sukaraja akan beroperasi mulai pukul 08:00 hingga 16:00 setiap hari kerja.',
            'cover' => 'cover_image_2.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Information::create([
            'jenis' => 'Berita',
            'judul' => 'Layanan Vaksinasi COVID-19',
            'isi' => 'Kami menyediakan layanan vaksinasi COVID-19 gratis untuk masyarakat umum.',
            'cover' => 'cover_image_3.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Information::create([
            'jenis' => 'Event',
            'judul' => 'Seminar Kesehatan Anak',
            'isi' => 'Puskesmas Sukaraja mengadakan seminar kesehatan untuk orang tua dan anak-anak pada tanggal 25 Agustus 2025.',
            'cover' => 'cover_image_4.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Information::create([
            'jenis' => 'Berita',
            'judul' => 'Puskesmas Sukaraja Menerima Penghargaan',
            'isi' => 'Puskesmas Sukaraja telah menerima penghargaan sebagai Puskesmas Terbaik 2025.',
            'cover' => 'cover_image_5.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

