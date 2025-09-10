@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="mb-4 text-2xl font-bold">Dashboard Admin</h1>

    <div class="flex flex-wrap gap-2 mb-4">
        <a href="{{ route('admin.users.indexAdmin') }}" class="btn btn-primary">Manajemen Pengguna</a>
        <a href="{{ route('admin.patients.indexAdmin') }}" class="btn btn-primary">Manajemen Pasien</a>
        <a href="{{ route('admin.informations.indexAdmin') }}" class="btn btn-primary">Manajemen Informasi</a>
        <a href="{{ route('admin.suggestions.indexAdmin') }}" class="btn btn-primary">Manajemen Saran</a>
        <a href="{{ route('admin.queues.indexAdmin') }}" class="btn btn-primary">Manajemen Antrian</a>
        <a href="{{ route('admin.patientsHistory.indexAdmin') }}" class="btn btn-primary">Riwayat Pasien</a>
    </div>

    <div class="mt-6">
        <h2 class="mb-2 text-xl font-semibold">Antrian Hari Ini</h2>

        @if($queues->isEmpty())
            <p class="text-gray-500">Tidak ada pasien dalam antrian hari ini.</p>
        @else
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">No Antrian</th>
                        <th class="px-4 py-2 border">NIK</th>
                        <th class="px-4 py-2 border">Nama Pasien</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queues as $queue)
                        <tr class="text-center">
                            <td class="px-4 py-2 border">{{ $queue->no_antrian }}</td>
                            <td class="px-4 py-2 border">{{ $queue->patient->nik }}</td>
                            <td class="px-4 py-2 border">{{ $queue->patient->nama }}</td>
                            <td class="px-4 py-2 border">
                                <form action="{{ route('admin.call', $queue->id_antrian) }}" method="POST" onsubmit="return confirm('Yakin ingin memanggil pasien ini?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600">
                                        Call
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
