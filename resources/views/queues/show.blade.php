@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Detail Antrian</h1>

        <div class="bg-gray-100 p-4 rounded-lg mb-4">
            <h2 class="text-xl font-semibold">No Antrian: {{ $queue->no_antrian }}</h2>
            <p class="text-sm text-gray-500">Pasien: {{ $queue->patient->nama_lengkap }}</p>
            <p class="text-sm text-gray-500">Jenis Kelamin: {{ $queue->patient->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            <p class="text-sm text-gray-500">Nomor Telepon: {{ $queue->patient->no_tel }}</p>
        </div>

        <a href="{{ route('queues.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded inline-block">Kembali ke Daftar Antrian</a>
    </div>
@endsection
