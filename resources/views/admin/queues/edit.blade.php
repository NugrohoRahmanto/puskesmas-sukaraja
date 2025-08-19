@extends('layouts.appadmin')

@section('content')
<div class="p-4 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Antrian</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.queues.updateAdmin', $queue->id_antrian) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="no_antrian" class="block font-semibold mb-2">No Antrian</label>
            <input type="number" id="no_antrian" name="no_antrian" value="{{ old('no_antrian', $queue->no_antrian) }}" class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update</button>
        <a href="{{ route('admin.queues.indexAdmin') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection
