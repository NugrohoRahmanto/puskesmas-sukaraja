@extends('layouts.app')

@section('content')
    <div class="max-w-sm mx-auto bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
        
        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium">Username</label>
                <input type="text" name="username" id="username" class="w-full p-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Login</button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">Lupa Password?</a>
        </div>

        <div class="mt-2 text-center">
            <p class="text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar Sekarang</a>
            </p>
        </div>
    </div>
@endsection
