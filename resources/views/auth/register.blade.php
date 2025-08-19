@extends('layouts.app')

@section('content')
    <div class="max-w-sm mx-auto bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Registrasi</h2>
        
        <!-- Menampilkan pesan error jika ada validasi yang gagal -->
        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Registrasi -->
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" name="username" id="username" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="no_tel" class="block text-sm font-medium">Nomor Telepon</label>
                <input type="text" name="no_tel" id="no_tel" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-sm font-medium">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="w-full p-2 border rounded" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="nama_lengkap" class="block text-sm font-medium">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded">Daftar</button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login Sekarang</a></p>
        </div>
    </div>
@endsection
