@extends('layouts.appadmin')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Pengguna</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.updateAdmin', $user->id_pengguna) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_lengkap" class="block text-sm font-semibold">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama_lengkap"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                    class="border border-gray-300 p-2 w-full @error('nama_lengkap') border-red-500 @enderror"
                    required
                >
                @error('nama_lengkap')
                    <p class="text-red-100 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="no_tel" class="block text-sm font-semibold">Nomor Telepon</label>
                <input
                    type="text"
                    id="no_tel"
                    name="no_tel"
                    value="{{ old('no_tel', $user->no_tel) }}"
                    class="border border-gray-300 p-2 w-full @error('no_tel') border-red-500 @enderror"
                    required
                    inputmode="tel"
                    autocomplete="tel"
                >
                @error('no_tel')
                    <p class="text-red-100 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-semibold">Status</label>
                <select
                    id="status"
                    name="status"
                    class="border border-gray-300 p-2 w-full @error('status') border-red-500 @enderror"
                    required
                >
                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-100 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="role" class="block text-sm font-semibold">Role</label>
                <select
                    id="role"
                    name="role"
                    class="border border-gray-300 p-2 w-full @error('role') border-red-500 @enderror"
                    required
                >
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="text-red-100 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                    Update Pengguna
                </button>
                <a href="{{ route('admin.users.indexAdmin') }}" class="text-gray-600 hover:underline">Kembali</a>
            </div>
        </form>
    </div>
@endsection
