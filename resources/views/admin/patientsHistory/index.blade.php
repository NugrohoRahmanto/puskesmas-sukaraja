@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="mb-4 text-2xl font-bold">Riwayat Pasien</h1>

    @if(session('success'))
        <div class="p-2 mb-4 bg-green-200">{{ session('success') }}</div>
    @endif

    <table class="w-full border border-gray-300 table-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-2 py-1 border">No</th>
                <th class="px-2 py-1 border">NIK</th>
                <th class="px-2 py-1 border">Nama</th>
                <th class="px-2 py-1 border">Pernah Berobat</th>
                <th class="px-2 py-1 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $index => $history)
            <tr>
                <td class="px-2 py-1 border">{{ $index + 1 }}</td>
                <td class="px-2 py-1 border">{{ $history->nik }}</td>
                <td class="px-2 py-1 border">{{ $history->nama }}</td>
                <td class="px-2 py-1 border">{{ $history->pernah_berobat }}</td>
                <td class="flex gap-2 px-2 py-1 border">
                    <a href="{{ route('admin.patientsHistory.editAdmin', $history->id_history) }}" class="px-2 py-1 bg-yellow-400 rounded">Edit</a>
                    <form action="{{ route('admin.patientsHistory.destroyAdmin', $history->id_history) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1 text-white bg-red-500 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
