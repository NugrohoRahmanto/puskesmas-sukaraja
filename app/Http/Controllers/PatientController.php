<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\PatientHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function index()
    {
        $patients = Auth::user()->patients;
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'usia' => 'required|integer',
            'jenis_kelamin' => 'required',
        ]);

        Patient::create([
            'id_pengguna' => auth()->id(),
            'nama_lengkap' => $request->nama_lengkap,
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('admin.patients.index');
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

    public function update(Request $request, $id_pasien)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'usia' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'no_tel' => 'nullable|string|max:15',
        ]);

        $patient = Patient::findOrFail($id_pasien);

        $patient->update([
            'nama_lengkap' => $request->nama_lengkap,
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_tel' => $request->no_tel,
        ]);

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
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'usia' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'no_tel' => 'nullable|string|max:15',
        ]);

        // Simpan data pasien
        $patient = Patient::create([
            'id_pengguna' => Auth::id(),
            'nama_lengkap' => $request->nama_lengkap,
            'usia' => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_tel' => $request->no_tel,
        ]);

        // Ambil tanggal sekarang dengan timezone Jakarta
        $dt = Carbon::now('Asia/Jakarta');          // full datetime
        $today = $dt->toDateString();               // hanya yyyy-mm-dd

        // Ambil nomor antrian terakhir untuk hari ini
        $lastQueue = Queue::whereDate('tanggal', $today)->latest()->first();
        $noAntrian = $lastQueue ? $lastQueue->no_antrian + 1 : 1;

        // Simpan antrian
        Queue::create([
            'id_pasien' => $patient->id_pasien,
            'no_antrian' => $noAntrian,
            'tanggal' => $today,   // simpan sebagai date, pastikan kolom bertipe date
            //'tanggal' => $dt->toDateTimeString(), // jika ingin datetime lengkap
        ]);

        return redirect()->route('patients.index')->with('success', 'Pasien dan Antrian berhasil ditambahkan.');
    }

    // Menampilkan semua pasien (Admin)
    public function indexAdmin()
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));
    }

    // Menampilkan form edit pasien
    public function editAdmin($id_pasien)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $patient = Patient::findOrFail($id_pasien);
        return view('admin.patients.edit', compact('patient'));
    }

    // Update data pasien
    public function updateAdmin(Request $request, $id_pasien)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'usia' => 'required|integer|min:0|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'no_tel' => 'nullable|string|max:15',
        ]);

        $patient = Patient::findOrFail($id_pasien);
        $patient->update($request->only(['nama_lengkap', 'usia', 'jenis_kelamin', 'no_tel']));

        return redirect()->route('admin.patients.indexAdmin')->with('success', 'Patient updated successfully');
    }

    // Hapus pasien
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

