@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Edit Profil</h1>

    <form method="POST" action="{{ route('user.me.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                   value="{{ old('username', $user->username) }}">
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control"
                   value="{{ old('nama_lengkap', $user->nama_lengkap) }}">
            @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $user->email) }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">No. Telp</label>
            <input type="text" name="no_tel" class="form-control"
                   value="{{ old('no_tel', $user->no_tel) }}">
            @error('no_tel') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('user.me') }}" class="btn btn-light">Batal</a>
    </form>
</div>
@endsection
