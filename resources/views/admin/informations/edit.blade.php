@extends('layouts.appadmin')

@section('title', 'Edit Informasi')

@section('content')
<div class="max-w-2xl mx-auto p-4 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Edit Informasi</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.informations.updateAdmin', $info->id_informasi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="jenis" class="block font-medium">Jenis</label>
            <input type="text" name="jenis" id="jenis" class="w-full border rounded p-2" value="{{ old('jenis', $info->jenis) }}" required>
        </div>

        <div class="mb-4">
            <label for="judul" class="block font-medium">Judul</label>
            <input type="text" name="judul" id="judul" class="w-full border rounded p-2" value="{{ old('judul', $info->judul) }}" required>
        </div>

        <div class="mb-4">
            <label for="isi" class="block font-medium">Isi</label>
            <textarea name="isi" id="isi" rows="6" class="w-full border rounded p-2" required>{{ old('isi', $info->isi) }}</textarea>
        </div>

       <div class="mb-4">
            <label for="cover" class="block font-medium">Cover (jpg/png, max 2MB)</label>
            <input type="text" value="{{ $info->cover ?? '' }}" class="w-full border rounded p-2 mb-2" readonly>
            <input type="file" name="cover" id="cover" class="w-full">
            <small class="text-gray-500">Kosongkan jika tidak ingin mengganti cover</small>
        </div>


        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Update
        </button>
        <a href="{{ route('admin.informations.indexAdmin') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection
