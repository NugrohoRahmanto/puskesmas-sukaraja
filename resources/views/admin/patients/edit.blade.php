@extends('layouts.appadmin')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Pasien</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
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
            <label for="nama_lengkap" class="block text-sm font-semibold">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $patient->nama_lengkap) }}" class="border border-gray-300 p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="usia" class="block text-sm font-semibold">Usia</label>
            <input type="number" id="usia" name="usia" value="{{ old('usia', $patient->usia) }}" class="border border-gray-300 p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="jenis_kelamin" class="block text-sm font-semibold">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="border border-gray-300 p-2 w-full" required>
                <option value="L" {{ $patient->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $patient->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="no_tel" class="block text-sm font-semibold">Nomor Telepon</label>
            <input type="text" id="no_tel" name="no_tel" value="{{ old('no_tel', $patient->no_tel) }}" class="border border-gray-300 p-2 w-full">
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Pasien</button>
            <a href="{{ route('admin.patients.indexAdmin') }}" class="ml-2 text-gray-500">Kembali</a>
        </div>
    </form>
</div>
@endsection
