<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Queue;
use App\Models\PatientHistory;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexAdmin()
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $today = Carbon::now('Asia/Jakarta')->startOfDay();

        $queues = Queue::with('patient')
            ->whereDate('tanggal', $today)
            ->orderBy('created_at')
            ->get()
            ->values()
            ->map(function ($queue, $index) {
                $queue->display_no = $index + 1;
                return $queue;
            });

        $countPerDate = function (Carbon $date) {
            $q  = Queue::whereDate('tanggal', $date)->count();
            $ph = PatientHistory::whereDate('tanggal', $date)->count();
            return $q + $ph;
        };

        $kpiToday = $countPerDate($today);

        $kpiWeek = 0;  // 7 hari termasuk hari ini
        for ($i = 0; $i < 7; $i++) {
            $kpiWeek += $countPerDate($today->copy()->subDays($i));
        }

        $kpiMonth = 0; // 30 hari termasuk hari ini
        for ($i = 0; $i < 30; $i++) {
            $kpiMonth += $countPerDate($today->copy()->subDays($i));
        }

        $kpiYear = 0;
        for ($i = 0; $i < 12; $i++) {
            $start = Carbon::now()->startOfMonth()->subMonths($i);
            $end   = $start->copy()->endOfMonth();

            $q  = Queue::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])->count();
            $ph = PatientHistory::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])->count();
            $kpiYear += ($q + $ph);
        }

        $ts7Labels = [];
        $ts7Data   = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = $today->copy()->subDays($i);
            $ts7Labels[] = $d->format('d M');
            $ts7Data[]   = $countPerDate($d);
        }

        $ts30Labels = [];
        $ts30Data   = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = $today->copy()->subDays($i);
            $ts30Labels[] = $d->format('d M');
            $ts30Data[]   = $countPerDate($d);
        }

        $ts12Labels = [];
        $ts12Data   = [];
        for ($i = 11; $i >= 0; $i--) {
            $start = Carbon::now()->startOfMonth()->subMonths($i);
            $end   = $start->copy()->endOfMonth();

            $label = $start->format('M Y');
            $q  = Queue::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])->count();
            $ph = PatientHistory::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])->count();

            $ts12Labels[] = $label;
            $ts12Data[]   = $q + $ph;
        }

        return view('admin.dashboard', [
            'queues' => $queues,
            'kpi'    => [
                'today' => $kpiToday,
                'week'  => $kpiWeek,
                'month' => $kpiMonth,
                'year'  => $kpiYear,
            ],
            'ts7'    => ['labels' => $ts7Labels,  'data' => $ts7Data],
            'ts30'   => ['labels' => $ts30Labels, 'data' => $ts30Data],
            'ts12'   => ['labels' => $ts12Labels, 'data' => $ts12Data],
        ]);
    }

    public function callAdmin($id_antrian)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $queue   = Queue::with('patient')->findOrFail($id_antrian);
        $patient = $queue->patient;

        if ($patient) {
            PatientHistory::create([
                'nik'             => $patient->nik ?? null,
                'nama'            => $patient->nama ?? $patient->nama_lengkap ?? '-',
                'pernah_berobat'  => $patient->pernah_berobat ?? 'Tidak',
                'gender'          => $patient->gender ?? 'Laki-laki',
                'tanggal'         => Carbon::now('Asia/Jakarta')->toDateString(),
                'no_antrian'      => $queue->no_antrian,
            ]);

            $patient->delete();
        }

        $queue->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pasien telah dipanggil, masuk ke riwayat, dan dihapus dari tabel pasien.');
    }
}
