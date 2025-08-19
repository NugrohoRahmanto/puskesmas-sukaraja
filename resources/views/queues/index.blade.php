@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Antrian</h1>

        @if($queues->isEmpty())
            <p class="text-gray-500">Tidak ada antrian saat ini.</p>
        @else
            <ul>
                @foreach ($queues as $queue)
                    <li class="mb-2">
                        No Antrian: {{ $queue->no_antrian }} - Pasien: {{ $queue->patient->nama_lengkap }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
