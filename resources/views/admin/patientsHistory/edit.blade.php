@extends('layouts.appadmin')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Riwayat Pasien</h1>

    @if ($errors->any())
        <div class="bg-red-200 p-2 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.patientsHistory.updateAdmin', $history->id_history) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <label class="block">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="border px-2 py-1 w-full" value="{{ $history->nama_lengkap }}">
        </div>

        <div class="mb-2">
            <label class="block">Usia</label>
            <input type="number" name="usia" class="border px-2 py-1 w-full" value="{{ $history->usia }}">
        </div>

        <div class="mb-2">
            <label class="block">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="border px-2 py-1 w-full">
                <option value="L" {{ $history->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $history->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-2">
            <label class="block">No Telp</label>
            <input type="text" name="no_tel" class="border px-2 py-1 w-full" value="{{ $history->no_tel }}">
        </div>

        <div class="mb-2">
            <label class="block">Tanggal</label>
            <input type="date" name="tanggal" class="border px-2 py-1 w-full" value="{{ $history->tanggal }}">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
