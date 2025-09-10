@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Riwayat Pasien</h1>

    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">No</th>
                <th class="border px-2 py-1">Nama</th>
                <th class="border px-2 py-1">Usia</th>
                <th class="border px-2 py-1">Jenis Kelamin</th>
                <th class="border px-2 py-1">No Telp</th>
                <th class="border px-2 py-1">Tanggal</th>
                <th class="border px-2 py-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $index => $history)
            <tr>
                <td class="border px-2 py-1">{{ $index + 1 }}</td>
                <td class="border px-2 py-1">{{ $history->nama_lengkap }}</td>
                <td class="border px-2 py-1">{{ $history->usia }}</td>
                <td class="border px-2 py-1">{{ $history->jenis_kelamin }}</td>
                <td class="border px-2 py-1">{{ $history->no_tel }}</td>
                <td class="border px-2 py-1">{{ $history->tanggal }}</td>
                <td class="border px-2 py-1 flex gap-2">
                    <a href="{{ route('admin.patientsHistory.editAdmin', $history->id_history) }}" class="bg-yellow-400 px-2 py-1 rounded">Edit</a>
                    <form action="{{ route('admin.patientsHistory.destroyAdmin', $history->id_history) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
