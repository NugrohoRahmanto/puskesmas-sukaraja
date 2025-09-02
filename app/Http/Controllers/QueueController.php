<?php
namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PatientHistory;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function index()
    {
        $queues = Queue::all();
        return view('queues.index', compact('queues'));
    }

    public function create()
    {
        $patients = Auth::user()->patients;
        return view('queues.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id_pasien',
            'no_antrian' => 'required|unique:queues,no_antrian',
        ]);

        Queue::create([
            'patient_id' => $request->patient_id,
            'no_antrian' => $request->no_antrian,
        ]);

        return redirect()->route('queues.index')->with('success', 'Antrian berhasil ditambahkan.');
    }

    public function edit(Queue $queue)
    {
        $this->authorize('update', $queue);

        $patients = Auth::user()->patients;
        return view('queues.edit', compact('queue', 'patients'));
    }

    public function update(Request $request, Queue $queue)
    {
        $this->authorize('update', $queue);

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id_pasien',
            'no_antrian' => 'required|unique:queues,no_antrian,' . $queue->id_antrian,
        ]);

        $queue->update([
            'patient_id' => $request->patient_id,
            'no_antrian' => $request->no_antrian,
        ]);

        return redirect()->route('queues.index')->with('success', 'Antrian berhasil diperbarui.');
    }

    public function destroy(Queue $queue)
    {
        $this->authorize('delete', $queue);
        $queue->delete();
        return redirect()->route('queues.index')->with('success', 'Antrian berhasil dihapus.');
    }

    public function indexAdmin()
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $queues = Queue::with('patient')->orderBy('no_antrian')->get();
        return view('admin.queues.index', compact('queues'));
    }

    public function editAdmin($id_antrian)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $queue = Queue::findOrFail($id_antrian);
        return view('admin.queues.edit', compact('queue'));
    }

    public function updateAdmin(Request $request, $id_antrian)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $request->validate([
            'no_antrian' => 'required|integer|min:1',
        ]);

        $queue = Queue::findOrFail($id_antrian);
        $queue->update([
            'no_antrian' => $request->no_antrian,
        ]);

        return redirect()->route('admin.queues.indexAdmin')->with('success', 'Nomor antrian berhasil diperbarui.');
    }

    public function destroyAdmin($id_antrian)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $queue = Queue::with('patient')->findOrFail($id_antrian);

        if ($queue->patient) {
            $queue->patient->delete();
        }

        $queue->delete();

        return redirect()->route('admin.queues.indexAdmin')->with('success', 'Antrian dan pasien terkait berhasil dihapus.');
    }

    public function callAdmin($id_antrian)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $queue = Queue::with('patient')->findOrFail($id_antrian);
        $patient = $queue->patient;

        if ($patient) {
            PatientHistory::create([
                'nama_lengkap' => $patient->nama_lengkap,
                'usia' => $patient->usia,
                'jenis_kelamin' => $patient->jenis_kelamin,
                'no_tel' => $patient->no_tel,
                'tanggal' => Carbon::today(),
                'no_antrian' => $queue->no_antrian,
            ]);

            $patient->delete();
        }

        $queue->delete();

        return redirect()->route('admin.queues.indexAdmin')->with('success', 'Pasien telah dipanggil, masuk ke riwayat, dan dihapus dari tabel pasien.');
    }
}
