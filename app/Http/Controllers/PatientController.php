<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\PatientHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $today = now()->toDateString();

        $patients = Auth::user()->patients()
            ->leftJoin('queues as q', function ($j) use ($today) {
                $j->on('q.id_pasien', '=', 'patients.id_pasien')
                ->whereDate('q.tanggal', $today);
            })
            ->select('patients.*', 'q.id_antrian as id_antrian', 'q.no_antrian')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('patients.index', compact('patients'));
    }


    public function search(Request $request)
    {
        $today = now()->toDateString();
        $q = trim($request->q ?? '');

        $patients = Auth::user()->patients()
            ->leftJoin('queues as q', function ($j) use ($today) {
                $j->on('q.id_pasien', '=', 'patients.id_pasien')
                ->whereDate('q.tanggal', $today);
            })
            ->when($q !== '', function ($w) use ($q) {
                $w->where(function ($qq) use ($q) {
                    $qq->where('patients.nik', 'like', "%{$q}%")
                    ->orWhere('patients.nama', 'like', "%{$q}%");
                });
            })
            ->select('patients.*', 'q.id_antrian as id_antrian', 'q.no_antrian')
            ->orderBy('patients.created_at', 'asc')
            ->get();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }


    public function show(Patient $patient)
    {
        return view('admin.patients.show', compact('patient'));
    }

    public function edit($id_pasien)
    {
        $patient = Patient::findOrFail($id_pasien);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        if ($patient->id_pengguna !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit data ini.');
        }

        $validated = $request->validate([
            'nik' => [
                'required','string','regex:/^[0-9]{16}$/',
                Rule::unique('patients', 'nik')->ignore($patient->id_pasien, 'id_pasien'),
            ],
            'nama' => ['required','string','max:255'],
            'pernah_berobat' => ['required','in:Ya,Tidak'],
        ], [
            'nik.regex' => 'NIK harus 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy($id_pasien)
    {
        $patient = Patient::findOrFail($id_pasien);

        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Pasien dan antrian terkait berhasil dihapus.');
    }

    public function createWithQueue()
    {
        return view('patients.createWithQueue');
    }

    public function storeWithQueue(Request $request)
    {
        $validated = $request->validate([
            'nik'             => ['required','string','size:16','regex:/^[0-9]+$/','unique:patients,nik'],
            'nama'            => ['required','string','max:255'],
            'pernah_berobat'  => ['required','in:Ya,Tidak'],
        ], [
            'nik.size'        => 'NIK harus 16 digit.',
            'nik.regex'       => 'NIK hanya boleh berisi angka.',
            'nik.unique'      => 'NIK sudah terdaftar.',
        ]);

        $today = Carbon::today()->toDateString();

        return DB::transaction(function () use ($validated, $today) {
            $patient = Patient::create([
                'id_pengguna'    => Auth::id(),
                'nik'            => $validated['nik'],
                'nama'           => $validated['nama'],
                'pernah_berobat' => $validated['pernah_berobat'],
            ]);

            $maxQueue = Queue::whereDate('tanggal', $today)->max('no_antrian');
            $maxHist  = PatientHistory::whereDate('tanggal', $today)->max('no_antrian');
            $lastNumber = max($maxQueue ?? 0, $maxHist ?? 0);
            $nextNumber = $lastNumber + 1;

            Queue::create([
                'id_pasien'  => $patient->id_pasien,
                'no_antrian' => $nextNumber,
                'tanggal'    => $today,
            ]);

            return redirect()
                ->route('patients.index')
                ->with('success', 'Pasien dan Antrian berhasil ditambahkan.');
        });
    }

    public function indexAdmin()
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $patients = Patient::orderBy('nik', 'asc')->get();
        return view('admin.patients.index', compact('patients'));
    }

    public function editAdmin($id_pasien)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $patient = Patient::findOrFail($id_pasien);
        return view('admin.patients.edit', compact('patient'));
    }

    public function updateAdmin(Request $request, $id_pasien)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $patient = Patient::findOrFail($id_pasien);

        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'regex:/^\d{16}$/',
                Rule::unique('patients', 'nik')->ignore($patient->id_pasien, 'id_pasien'),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'pernah_berobat' => ['required', 'in:Ya,Tidak'],
        ], [
            'nik.regex' => 'NIK harus 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
        ]);

        $patient->update($validated);
        return redirect()
        ->route('admin.patients.indexAdmin')
        ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroyAdmin($id_pasien)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $patient = Patient::findOrFail($id_pasien);
        $patient->delete();

        return redirect()->route('admin.patients.indexAdmin')->with('success', 'Patient deleted successfully');
    }
}
