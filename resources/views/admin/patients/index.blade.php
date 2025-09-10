@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Manajemen Pasien</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border px-4 py-2">Nama Lengkap</th>
                <th class="border px-4 py-2">Usia</th>
                <th class="border px-4 py-2">Jenis Kelamin</th>
                <th class="border px-4 py-2">No Telepon</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td class="border px-4 py-2">{{ $patient->nama_lengkap }}</td>
                    <td class="border px-4 py-2">{{ $patient->usia }}</td>
                    <td class="border px-4 py-2">{{ $patient->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="border px-4 py-2">{{ $patient->no_tel }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('admin.patients.editAdmin', $patient->id_pasien) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.patients.destroyAdmin', $patient->id_pasien) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Danger</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
