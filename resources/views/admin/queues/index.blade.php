@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Antrian</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-2 py-1">No Antrian</th>
                <th class="border px-2 py-1">Nama Pasien</th>
                <th class="border px-2 py-1">Usia</th>
                <th class="border px-2 py-1">Jenis Kelamin</th>
                <th class="border px-2 py-1">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($queues as $queue)
                <tr>
                    <td class="border px-2 py-1">{{ $queue->no_antrian }}</td>
                    <td class="border px-2 py-1">{{ $queue->patient->nama_lengkap }}</td>
                    <td class="border px-2 py-1">{{ $queue->patient->usia }}</td>
                    <td class="border px-2 py-1">{{ $queue->patient->jenis_kelamin }}</td>
                    <td class="border px-2 py-1 space-x-2">
                        <a href="{{ route('admin.queues.editAdmin', $queue->id_antrian) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>

                        <form action="{{ route('admin.queues.destroyAdmin', $queue->id_antrian) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus antrian ini?')" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                        </form>

                        <form action="{{ route('admin.queues.callAdmin', $queue->id_antrian) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Panggil pasien ini?')" class="bg-green-500 text-white px-2 py-1 rounded">Call</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
