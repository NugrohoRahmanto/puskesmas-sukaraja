@extends('layouts.app')
@section('content')
<div class="max-w-sm mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Lupa Password</h2>
    @if (session('status'))
        <div class="mb-3 text-green-600">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2 rounded @error('email') border-red-500 @enderror">
        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded">Kirim Link Reset</button>
    </form>
</div>
@endsection
