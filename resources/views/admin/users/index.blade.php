@extends('layouts.appadmin')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Manajemen Pengguna</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">Nama Lengkap</th>
                        <th class="border px-4 py-2 text-left">Username</th>
                        <th class="border px-4 py-2 text-left">Email</th>
                        <th class="border px-4 py-2 text-left">No Telepon</th>
                        <th class="border px-4 py-2 text-left">Status</th>
                        <th class="border px-4 py-2 text-left">Role</th>
                        <th class="border px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $user->nama_lengkap }}</td>
                            <td class="border px-4 py-2">{{ $user->username }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2">{{ $user->no_tel }}</td>
                            <td class="border px-4 py-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td class="border px-4 py-2 capitalize">{{ $user->role }}</td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('admin.users.editAdmin', $user->id_pengguna) }}"
                                   class="text-blue-600 hover:underline mr-3">
                                    Edit
                                </a>
                                <form action="{{ route('admin.users.destroyAdmin', $user->id_pengguna) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border px-4 py-6 text-center text-gray-500">
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
