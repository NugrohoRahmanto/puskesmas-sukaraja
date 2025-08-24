@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Ganti Password</h1>

    <form method="POST" action="{{ route('user.me.password.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Password Saat Ini</label>
            <input type="password" name="current_password" class="form-control">
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="new_password" class="form-control">
            @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="form-control">
        </div>

        <button class="btn btn-primary">Perbarui Password</button>
        <a href="{{ route('user.me') }}" class="btn btn-light">Batal</a>
    </form>
</div>
@endsection
