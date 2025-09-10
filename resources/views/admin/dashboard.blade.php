@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

    <div class="mb-4 flex flex-wrap gap-2">
        <a href="{{ route('admin.users.indexAdmin') }}" class="btn btn-primary">Manajemen Pengguna</a>
        <a href="{{ route('admin.patients.indexAdmin') }}" class="btn btn-primary">Manajemen Pasien</a>
        <a href="{{ route('admin.informations.indexAdmin') }}" class="btn btn-primary">Manajemen Informasi</a>
        <a href="{{ route('admin.suggestions.indexAdmin') }}" class="btn btn-primary">Manajemen Saran</a>
        <a href="{{ route('admin.queues.indexAdmin') }}" class="btn btn-primary">Manajemen Antrian</a>
        <a href="{{ route('admin.patientsHistory.indexAdmin') }}" class="btn btn-primary">Riwayat Pasien</a>
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-2">Antrian Hari Ini</h2>

        @if($queues->isEmpty())
            <p class="text-gray-500">Tidak ada pasien dalam antrian hari ini.</p>
        @else
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">No Antrian</th>
                        <th class="border px-4 py-2">Nama Pasien</th>
                        <th class="border px-4 py-2">Usia</th>
                        <th class="border px-4 py-2">Jenis Kelamin</th>
                        <th class="border px-4 py-2">No Telp</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queues as $queue)
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $queue->no_antrian }}</td>
                            <td class="border px-4 py-2">{{ $queue->patient->nama_lengkap }}</td>
                            <td class="border px-4 py-2">{{ $queue->patient->usia }}</td>
                            <td class="border px-4 py-2">{{ $queue->patient->jenis_kelamin }}</td>
                            <td class="border px-4 py-2">{{ $queue->patient->no_tel ?? '-' }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('admin.call', $queue->id_antrian) }}" method="POST" onsubmit="return confirm('Yakin ingin memanggil pasien ini?');">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
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
