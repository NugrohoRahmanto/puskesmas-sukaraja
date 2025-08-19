@extends('layouts.app')

@section('content')
<div class="p-4 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Saran</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('suggestions.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="keterangan" class="block font-semibold mb-2">Keterangan Saran</label>
            <textarea id="keterangan" name="keterangan" rows="5" class="w-full border rounded p-2" required>{{ old('keterangan') }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Tambah Saran</button>
        <a href="{{ route('dashboard') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection
