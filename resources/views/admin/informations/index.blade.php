@extends('layouts.appadmin')

@section('title', 'Daftar Informasi')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Informasi</h1>

    <a href="{{ route('admin.informations.createAdmin') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">
        Tambah Informasi
    </a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-300 rounded">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Jenis</th>
                <th class="border px-4 py-2">Judul</th>
                <th class="border px-4 py-2">Isi</th>
                <th class="border px-4 py-2">Cover</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($infos as $index => $info)
            <tr>
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $info->jenis }}</td>
                <td class="border px-4 py-2">{{ $info->judul }}</td>
                <td class="border px-4 py-2">{{ Str::limit($info->isi, 50) }}</td>
                <td class="border px-4 py-2">{{ $info->cover ?? '-' }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.informations.editAdmin', $info->id_informasi) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('admin.informations.destroyAdmin', $info->id_informasi) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus informasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($infos->isEmpty())
            <tr>
                <td colspan="6" class="border px-4 py-2 text-center">Belum ada informasi.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
