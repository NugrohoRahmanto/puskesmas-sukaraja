@extends('layouts.app')

@section('content')
    <div class="max-w-sm mx-auto bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Registrasi</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    value="{{ old('username') }}"
                    class="w-full p-2 border rounded @error('username') border-red-500 @enderror"
                    required
                    autocomplete="username"
                >
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    class="w-full p-2 border rounded @error('email') border-red-500 @enderror"
                    required
                    autocomplete="email"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama_lengkap" class="block text-sm font-medium">Nama Lengkap</label>
                <input
                    type="text"
                    name="nama_lengkap"
                    id="nama_lengkap"
                    value="{{ old('nama_lengkap') }}"
                    class="w-full p-2 border rounded @error('nama_lengkap') border-red-500 @enderror"
                    required
                    autocomplete="name"
                >
                @error('nama_lengkap')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="no_tel" class="block text-sm font-medium">Nomor Telepon</label>
                <input
                    type="text"
                    name="no_tel"
                    id="no_tel"
                    value="{{ old('no_tel') }}"
                    class="w-full p-2 border rounded @error('no_tel') border-red-500 @enderror"
                    required
                    inputmode="tel"
                    autocomplete="tel"
                >
                @error('no_tel')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full p-2 border rounded @error('password') border-red-500 @enderror"
                    required
                    autocomplete="new-password"
                    minlength="8"
                >
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="w-full p-2 border rounded"
                    required
                    autocomplete="new-password"
                    minlength="8"
                >
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded">Daftar</button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login Sekarang</a>
            </p>
        </div>
    </div>
@endsection
