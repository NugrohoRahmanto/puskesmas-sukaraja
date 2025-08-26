@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Profil Saya</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="list-disc pl-5">
        <li>Username: {{ $user->username }}</li>
        <li>Nama Lengkap: {{ $user->nama_lengkap }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>No. Telp: {{ $user->no_tel ?? '-' }}</li>
        <li>Role: {{ $user->role }}</li>
        <li>Status: {{ $user->status ?? '-' }}</li>
    </ul>

    <div class="mt-4 space-x-2">
        <a href="{{ route('user.me.edit') }}" class="btn btn-primary">Edit Profil</a>
        <a href="{{ route('user.me.password.edit') }}" class="btn btn-secondary">Ganti Password</a>
    </div>
</div>
@endsection
