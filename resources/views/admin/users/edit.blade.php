@extends('layouts.appadmin')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Pengguna</h1>

        <!-- Menampilkan pesan error atau sukses -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form untuk mengedit pengguna -->
        <form action="{{ route('admin.users.updateAdmin', $user->id_pengguna) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Field untuk Nama Lengkap -->
            <div class="mb-4">
                <label for="nama_lengkap" class="block text-sm font-semibold">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" class="border border-gray-300 p-2 w-full" required>
            </div>

            <!-- Field untuk No Telepon -->
            <div class="mb-4">
                <label for="no_tel" class="block text-sm font-semibold">Nomor Telepon</label>
                <input type="text" id="no_tel" name="no_tel" value="{{ old('no_tel', $user->no_tel) }}" class="border border-gray-300 p-2 w-full" required>
            </div>

            <!-- Field untuk Jenis Kelamin -->
            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-sm font-semibold">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="border border-gray-300 p-2 w-full" required>
                    <option value="L" {{ $user->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $user->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Tombol untuk Update -->
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Pengguna</button>
                <a href="{{ route('admin.users.indexAdmin') }}" class="ml-2 text-gray-500">Kembali</a>
            </div>
        </form>
    </div>
@endsection
