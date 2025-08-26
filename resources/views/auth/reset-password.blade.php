@extends('layouts.app')
@section('content')
<div class="max-w-sm mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Reset Password</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2 rounded @error('email') border-red-500 @enderror">
        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror

        <label class="block text-sm font-medium mb-1 mt-3">Password Baru</label>
        <input type="password" name="password" required minlength="8" class="w-full border p-2 rounded @error('password') border-red-500 @enderror">
        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror

        <label class="block text-sm font-medium mb-1 mt-3">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required minlength="8" class="w-full border p-2 rounded">

        <button class="mt-4 w-full bg-green-600 text-white py-2 rounded">Reset Password</button>
    </form>
</div>
@endsection
