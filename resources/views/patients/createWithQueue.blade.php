@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Tambah Pasien dan Antrian</h1>

        <form action="{{ route('patients.storeWithQueue') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama_lengkap" class="block text-sm font-medium">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="usia" class="block text-sm font-medium">Usia</label>
                <input type="number" name="usia" id="usia" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-sm font-medium">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="w-full p-2 border rounded" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="no_tel" class="block text-sm font-medium">Nomor Telepon</label>
                <input type="text" name="no_tel" id="no_tel" class="w-full p-2 border rounded">
            </div>

            <!-- Hapus kolom nomor antrian karena sudah otomatis di-generate -->
            <!-- <div class="mb-4">
                <label for="no_antrian" class="block text-sm font-medium">Nomor Antrian</label>
                <input type="text" name="no_antrian" id="no_antrian" class="w-full p-2 border rounded" required>
            </div> -->

            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded mt-4">Tambah Pasien dan Antrian</button>
        </form>
    </div>
@endsection
