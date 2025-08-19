@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Pasien</h1>

        @if (isset($patients) && $patients->isEmpty())
            <p class="text-gray-500">Anda belum mendaftarkan pasien apapun.</p>
        @elseif (isset($patients) && !$patients->isEmpty())
            <ul>
                @foreach ($patients as $patient)
                    <li class="mb-2">
                        {{ $patient->nama_lengkap }} - {{ $patient->usia }} tahun
                        <p>No Antrian: {{ $patient->no_antrian }}</p>  <!-- Menampilkan nomor antrian terbaru -->
                        <a href="{{ route('patients.edit', $patient->id_pasien) }}" class="text-blue-500 ml-2">Edit</a>
                        <form action="{{ route('patients.destroy', $patient->id_pasien) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Hapus</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Tidak ada data pasien.</p>
        @endif

        <a href="{{ route('patients.createWithQueue') }}" class="bg-green-500 text-white py-2 px-4 rounded mt-4 inline-block">Tambah Pasien</a>
    </div>
@endsection
