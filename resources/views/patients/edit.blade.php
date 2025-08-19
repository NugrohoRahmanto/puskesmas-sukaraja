@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Pasien</h1>

        <!-- Form Edit Pasien -->
        <form action="{{ route('patients.update', $patient->id_pasien) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_lengkap" class="block">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $patient->nama_lengkap) }}" required>
            </div>

            <div class="mb-4">
                <label for="usia" class="block">Usia</label>
                <input type="number" id="usia" name="usia" class="form-control" value="{{ old('usia', $patient->usia) }}" required>
            </div>

            <div class="mb-4">
                <label for="jenis_kelamin" class="block">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                    <option value="L" {{ $patient->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $patient->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="no_tel" class="block">Nomor Telepon</label>
                <input type="text" id="no_tel" name="no_tel" class="form-control" value="{{ old('no_tel', $patient->no_tel) }}">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>  <!-- Tombol Kembali -->
        </form>
    </div>
@endsection
