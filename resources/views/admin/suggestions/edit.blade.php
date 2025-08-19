@extends('layouts.appadmin')

@section('content')
<div class="p-4 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Saran</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.suggestions.updateAdmin', $suggestion->id_saran) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="keterangan" class="block font-semibold mb-2">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="5" class="w-full border rounded px-3 py-2" required>{{ old('keterangan', $suggestion->keterangan) }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.suggestions.indexAdmin') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Kembali</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
