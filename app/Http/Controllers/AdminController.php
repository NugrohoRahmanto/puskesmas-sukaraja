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
        // dd($today);
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
        $patient = $queue->patient;

        if ($patient) {
            // Simpan ke history
            PatientHistory::create([
                'nama_lengkap' => $patient->nama_lengkap,
                'usia' => $patient->usia,
                'jenis_kelamin' => $patient->jenis_kelamin,
                'no_tel' => $patient->no_tel,
                'tanggal' => Carbon::today(),
            ]);

            // Hapus pasien
            $patient->delete();
        }

        // Hapus antrian
        $queue->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Pasien telah dipanggil, masuk ke riwayat, dan dihapus dari tabel pasien.');
    }
}
