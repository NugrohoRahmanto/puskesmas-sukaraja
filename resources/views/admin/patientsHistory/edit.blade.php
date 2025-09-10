@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="mb-4 text-2xl font-bold">Edit Riwayat Pasien</h1>

    @if ($errors->any())
        <div class="p-2 mb-4 bg-red-200">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.patientsHistory.updateAdmin', $history->id_history) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nik" class="block text-sm font-semibold">NIK</label>
            <input type="number" id="nik" name="nik" value="{{ old('nik', $history->nik) }}" class="w-full p-2 border border-gray-300" required>
        </div>

        <div class="mb-4">
            <label for="nama" class="block text-sm font-semibold">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $history->nama) }}" class="w-full p-2 border border-gray-300" required>
        </div>

         <div class="mb-4">
            <label for="pernah_berobat" class="block text-sm font-semibold">Pernah Berobat</label>
            <input type="text" id="pernah_berobat" name="pernah_berobat" value="{{ old('pernah_berobat', $history->pernah_berobat) }}" class="w-full p-2 border border-gray-300" required>
        </div>

         <div class="mb-4">
            <label for="no_antrian" class="block text-sm font-semibold">No Antrian</label>
            <input type="text" id="no_antrian" name="no_antrian" value="{{ old('no_antrian', $history->no_antrian) }}" class="w-full p-2 border border-gray-300" required>
        </div>
        
        <div class="mb-4">
            <label class="block">Tanggal</label>
            <input type="date" name="tanggal" class="w-full px-2 py-1 border" value="{{ $history->tanggal }}">
        </div>


        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Update</button>
    </form>
</div>
@endsection
