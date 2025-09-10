@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="mb-4 text-2xl font-bold">Daftar Antrian</h1>

    @if(session('success'))
        <div class="px-4 py-2 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-2 py-1 border">No Antrian</th>
                <th class="px-2 py-1 border">NIK</th>
                <th class="px-2 py-1 border">Nama</th>
                <th class="px-2 py-1 border">Pernah Berobat</th>
                <th class="px-2 py-1 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($queues as $queue)
                <tr>
                    <td class="px-2 py-1 border">{{ $queue->no_antrian }}</td>
                    <td class="px-2 py-1 border">{{ $queue->patient->nik }}</td>
                    <td class="px-2 py-1 border">{{ $queue->patient->nama }}</td>
                    <td class="px-2 py-1 border">{{ $queue->patient->pernah_berobat }}</td>
                    <td class="px-2 py-1 space-x-2 border">
                        <a href="{{ route('admin.queues.editAdmin', $queue->id_antrian) }}" class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</a>

                        <form action="{{ route('admin.queues.destroyAdmin', $queue->id_antrian) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus antrian ini?')" class="px-2 py-1 text-white bg-red-500 rounded">Hapus</button>
                        </form>

                        <form action="{{ route('admin.queues.callAdmin', $queue->id_antrian) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Panggil pasien ini?')" class="px-2 py-1 text-white bg-green-500 rounded">Call</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
