@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="mb-4 text-2xl font-bold">Edit Pasien</h1>

    @if ($errors->any())
        <div class="p-2 mb-4 text-white bg-red-500 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.patients.updateAdmin', $patient->id_pasien) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nik" class="block text-sm font-semibold">NIK</label>
            <input type="number" id="nik" name="nik" value="{{ old('nik', $patient->nik) }}" class="w-full p-2 border border-gray-300" required>
        </div>

        <div class="mb-4">
            <label for="nama" class="block text-sm font-semibold">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $patient->nama) }}" class="w-full p-2 border border-gray-300" required>
        </div>

         <div class="mb-4">
            <label for="pernah_berobat" class="block text-sm font-semibold">Pernah Berobat</label>
            <input type="text" id="pernah_berobat" name="pernah_berobat" value="{{ old('pernah_berobat', $patient->pernah_berobat) }}" class="w-full p-2 border border-gray-300" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Update Pasien</button>
            <a href="{{ route('admin.patients.indexAdmin') }}" class="ml-2 text-gray-500">Kembali</a>
        </div>
    </form>
</div>
@endsection
