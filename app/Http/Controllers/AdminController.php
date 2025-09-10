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

        $today = Carbon::today();
        $queues = Queue::with('patient')
                            ->whereDate('tanggal', $today)
                            ->orderBy('no_antrian', 'asc')
                            ->get();

        return view('admin.dashboard', compact('queues'));
    }

    public function callAdmin($id_antrian)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $queue = Queue::with('patient')->findOrFail($id_antrian);
        // dd($queue->no_antrian);
        $patient = $queue->patient;

        if ($patient) {
            PatientHistory::create([
                'nik' => $patient->nik,
                'nama' => $patient->nama,
                'pernah_berobat' => $patient->pernah_berobat,
                'tanggal' => Carbon::today(),
                'no_antrian' => $queue->no_antrian,
            ]);

            $patient->delete();
        }

        $queue->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Pasien telah dipanggil, masuk ke riwayat, dan dihapus dari tabel pasien.');
    }
}
