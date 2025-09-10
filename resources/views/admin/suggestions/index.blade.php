@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Manajemen Saran</h1>

    @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Pengguna</th>
                <th class="px-4 py-2">Keterangan</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suggestions as $index => $suggestion)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2">{{ $suggestion->user->name ?? 'Unknown' }}</td>
                <td class="px-4 py-2">{{ $suggestion->keterangan }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.suggestions.editAdmin', $suggestion->id_saran) }}" class="text-blue-500">Edit</a>
                    <form action="{{ route('admin.suggestions.destroyAdmin', $suggestion->id_saran) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus saran ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 ml-2">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
