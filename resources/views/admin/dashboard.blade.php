@extends('layouts.admin')
@section('title','Dashboard Admin')

@section('content')
<div class="px-4 pt-10 pb-8 min-h-[100svh] grid place-items-center">
  <div class="relative w-full max-w-6xl bg-slate-100 rounded-[22px] p-6 md:p-8">

    {{-- PILL HEADER --}}
    <div class="absolute -translate-x-1/2 -top-5 left-1/2">
      <div class="px-6 py-2 text-base md:text-lg font-semibold text-center text-white
                  rounded-full shadow border border-slate-200 bg-brand-700 whitespace-nowrap">
        Dashboard Admin
      </div>
    </div>

    {{-- ====== VISUALISASI PASIEN ====== --}}
    <section class="mb-8">
      <h2 class="text-lg font-semibold mb-3 text-slate-800">Visualisasi Pasien</h2>

      {{-- KPI CARDS --}}
      <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
        <div class="rounded-2xl bg-white border border-slate-200 p-4">
          <p class="text-xs uppercase tracking-wider text-slate-500">Hari Ini</p>
          <p class="mt-1 text-2xl font-bold text-slate-900 tabular-nums">{{ $kpi['today'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200 p-4">
          <p class="text-xs uppercase tracking-wider text-slate-500">7 Hari</p>
          <p class="mt-1 text-2xl font-bold text-slate-900 tabular-nums">{{ $kpi['week'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200 p-4">
          <p class="text-xs uppercase tracking-wider text-slate-500">30 Hari</p>
          <p class="mt-1 text-2xl font-bold text-slate-900 tabular-nums">{{ $kpi['month'] ?? 0 }}</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200 p-4">
          <p class="text-xs uppercase tracking-wider text-slate-500">12 Bulan</p>
          <p class="mt-1 text-2xl font-bold text-slate-900 tabular-nums">{{ $kpi['year'] ?? 0 }}</p>
        </div>
      </div>

      {{-- CHART CARD --}}
      <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <div class="flex items-center justify-between mb-2">
          <p class="text-sm font-medium text-slate-800">Jumlah Pasien</p>
          <div class="flex gap-1">
            <button type="button" data-range="7"
              class="range-btn inline-flex items-center rounded-full border border-slate-300 px-3 py-1.5 text-xs hover:bg-slate-100 hover:text-brand-700">7 Hari</button>
            <button type="button" data-range="30"
              class="range-btn inline-flex items-center rounded-full border border-slate-300 px-3 py-1.5 text-xs hover:bg-slate-100 hover:text-brand-700">30 Hari</button>
            <button type="button" data-range="365"
              class="range-btn inline-flex items-center rounded-full border border-slate-300 px-3 py-1.5 text-xs hover:bg-slate-100 hover:text-brand-700">12 Bulan</button>
          </div>
        </div>
        <div class="h-64 md:h-80">
          <canvas id="patientsChart"></canvas>
        </div>
        <p class="mt-2 text-[11px] text-slate-500">Tip: klik label legend untuk show/hide dataset.</p>
      </div>
    </section>

    {{-- ====== ANTRIAN HARI INI ====== --}}
    <section aria-labelledby="today-queues">
      <div class="mb-3">
        <div class="px-5 py-1.5 inline-flex items-center gap-2 bg-white border border-slate-200 rounded-full text-[12px] text-slate-700">
          <x-heroicon-o-queue-list class="w-4 h-4"/>
          Antrian Hari Ini
        </div>
      </div>

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
                  <td class="px-4 py-3">{{ $q->patient->nama_lengkap ?? $q->patient->nama ?? '—' }}</td>
                  <td class="px-4 py-3">
                    <form action="{{ route('admin.call', $q->id_antrian ?? $q->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin memanggil pasien ini?');" class="inline">
                      @csrf
                      <button type="submit"
                              class="inline-flex items-center gap-2 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 text-sm">
                        <x-heroicon-o-phone class="w-4 h-4"/> Panggil
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

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

  const ts7  = @json($ts7 ?? ['labels'=>[], 'data'=>[]]);
  const ts30 = @json($ts30 ?? ['labels'=>[], 'data'=>[]]);
  const ts12 = @json($ts12 ?? ['labels'=>[], 'data'=>[]]);

  const ctx = document.getElementById('patientsChart').getContext('2d');


  let labels = ts7.labels || [];
  let data   = ts7.data   || [];

  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Jumlah Pasien',
        data,
        tension: 0.3,
        borderWidth: 2,
        pointRadius: 2,
        fill: true,
        backgroundColor: 'rgba(14,122,58,0.08)', // brand-700 alpha
        borderColor: '#0E7A3A'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { intersect: false, mode: 'index' },
      plugins: {
        legend: { display: true },
        tooltip: { callbacks: {
          label: (ctx) => ` ${ctx.dataset.label}: ${ctx.parsed.y}`
        } }
      },
      scales: {
        x: { grid: { display: false } },
        y: { beginAtZero: true, ticks: { precision:0 } }
      }
    }
  });

  function setRange(range) {
    let src = ts7;
    if (range === '30') src = ts30;
    if (range === '365') src = ts12;

    chart.data.labels = src.labels || [];
    chart.data.datasets[0].data = src.data || [];
    chart.update();

    document.querySelectorAll('.range-btn').forEach(b=>{
      b.classList.remove('bg-brand-700','text-white','border-brand-700');
      b.classList.add('border-slate-300');
    });
    const active = document.querySelector(`.range-btn[data-range="${range}"]`);
    if (active) {
      active.classList.add('bg-brand-700','text-white','border-brand-700');
      active.classList.remove('border-slate-300');
    }
  }

  setRange('7');

  document.querySelectorAll('.range-btn').forEach(btn=>{
    btn.addEventListener('click', ()=> setRange(btn.dataset.range));
  });
});
</script>
@endpush
