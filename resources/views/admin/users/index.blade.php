@extends('layouts.appadmin')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Manajemen Pengguna</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Nama Lengkap</th>
                    <th class="border px-4 py-2">No Telepon</th>
                    <th class="border px-4 py-2">Jenis Kelamin</th>
                    <th class="border px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user->nama_lengkap }}</td>
                        <td class="border px-4 py-2">{{ $user->no_tel }}</td>
                        <td class="border px-4 py-2">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.users.editAdmin', $user->id_pengguna) }}" class="text-blue-500">Edit</a> |
                            <form action="{{ route('admin.users.destroyAdmin', $user->id_pengguna) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
