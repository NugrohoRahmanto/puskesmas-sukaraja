@extends('layouts.admin')

@section('content')
<div class="p-4">
    <h1 class="mb-4 text-2xl font-bold">Manajemen Pasien</h1>

    @if(session('success'))
        <div class="p-2 mb-4 text-white bg-green-500 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-collapse border-gray-300 table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2 border">NIK/th>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Pernah Berobat</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td class="px-4 py-2 border">{{ $patient->nik }}</td>
                    <td class="px-4 py-2 border">{{ $patient->nama }}</td>
                    <td class="px-4 py-2 border">{{ $patient->pernah_berobat}}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.patients.editAdmin', $patient->id_pasien) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.patients.destroyAdmin', $patient->id_pasien) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
