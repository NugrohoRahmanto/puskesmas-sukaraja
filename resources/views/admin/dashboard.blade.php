@extends('layouts.admin')
@section('title','Dashboard Admin')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Antrian Hari Ini
      </div>
    </div>

    {{-- ANTRIAN HARI INI --}}
    <section aria-labelledby="today-queues">
      @if($queues->isEmpty())
        <div class="px-4 py-10 text-center text-slate-600 bg-white border border-slate-200 rounded-2xl">
          Tidak ada pasien dalam antrian hari ini.
        </div>
      @else
        <div class="overflow-x-auto bg-white border border-slate-200 rounded-2xl">
          <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-700 border-b border-slate-200">
              <tr>
                <th class="px-4 py-3 text-left font-medium">No Antrian</th>
                <th class="px-4 py-3 text-left font-medium">NIK</th>
                <th class="px-4 py-3 text-left font-medium">Nama Pasien</th>
                <th class="px-4 py-3 text-left font-medium">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
              @foreach($queues as $q)
                <tr class="bg-white hover:bg-slate-50">
                  <td class="px-4 py-3 font-semibold tabular-nums">{{ $q->no_antrian }}</td>
                  <td class="px-4 py-3">{{ $q->patient->nik ?? '—' }}</td>
                  <td class="px-4 py-3">
                    {{ $q->patient->nama_lengkap ?? $q->patient->nama ?? '—' }}
                  </td>
                  <td class="px-4 py-3">
                    <form action="{{ route('admin.call', $q->id_antrian ?? $q->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin memanggil pasien ini?');" class="inline">
                      @csrf
                      <button type="submit"
                              class="inline-flex items-center gap-2 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 text-sm">
                        <x-heroicon-o-phone class="w-4 h-4"/>
                        Panggil
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </section>

  </div>
</div>
@endsection
