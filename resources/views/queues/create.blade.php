@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Tambah Antrian</h1>

        <form action="{{ route('queues.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="patient_id" class="block text-sm font-medium">Pasien</label>
                <select name="patient_id" id="patient_id" class="w-full p-2 border rounded" required>
                    <option value="">Pilih Pasien</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id_pasien }}">{{ $patient->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="no_antrian" class="block text-sm font-medium">No Antrian</label>
                <input type="text" name="no_antrian" id="no_antrian" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">Tambah Antrian</button>
        </form>
    </div>
@endsection
