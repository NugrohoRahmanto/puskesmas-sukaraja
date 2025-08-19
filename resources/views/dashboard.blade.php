@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    @if (Auth::check())  <!-- Pastikan hanya yang login yang bisa melihat tombol ini -->
        <a href="{{ route('patients.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">Lihat Daftar Pasien</a>
        <a href="{{ route('suggestions.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">Beri Saran/Masukan</a>
    @else
        <p class="mb-4">Silakan login untuk melihat daftar pasien Anda.</p>
    @endif

    <!-- Tombol untuk melihat antrian, tampil untuk semua user -->
    <a href="{{ route('suggestions.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded mb-4 inline-block">Lihat Antrian</a>

    <!-- Informasi Terbaru -->
    <div class="mt-4">
        <h2 class="text-xl font-semibold mb-2">Informasi Terbaru</h2>
        @if($latestInfo->isEmpty())
            <p class="text-gray-500">Tidak ada informasi terbaru.</p>
        @else
            <ul>
                @foreach ($latestInfo as $info)
                    <li class="mb-6 border-b pb-4">
                        <div class="flex flex-col md:flex-row gap-4">
                            @if($info->cover)
                                <img src="{{ asset('storage/covers/' . $info->cover) }}" 
                                     alt="{{ $info->judul }}" 
                                     class="w-32 h-32 object-cover rounded">
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg">{{ $info->judul }}</h3>
                                <p class="text-sm text-gray-500">{{ $info->created_at->format('d F Y') }}</p>
                                <p class="mt-1">{{ Str::limit($info->isi, 150) }}</p>
                                {{-- Jika mau tambahkan link "Baca Selengkapnya" --}}
                                {{-- <a href="{{ route('informations.show', $info->id_informasi) }}" class="text-blue-500 mt-2 inline-block">Baca Selengkapnya</a> --}}
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
    