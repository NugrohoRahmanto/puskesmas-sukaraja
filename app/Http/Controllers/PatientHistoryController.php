<?php

namespace App\Http\Controllers;
use App\Models\PatientHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PatientHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexAdmin()
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                             ->withErrors('You are not authorized to access this page');
        }

        $histories = PatientHistory::orderBy('tanggal', 'desc')->get();
        return view('admin.patientsHistory.index', compact('histories'));
    }

    public function editAdmin($id_history)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                             ->withErrors('You are not authorized to access this page');
        }

        $history = PatientHistory::findOrFail($id_history);
        return view('admin.patientsHistory.edit', compact('history'));
    }

    public function updateAdmin(Request $request, $id_history)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak berhak mengakses halaman ini.');
        }

        $history = PatientHistory::findOrFail($id_history);

        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'regex:/^\d{16}$/',
            ],
            'nama' => ['required', 'string', 'max:255'],
            'pernah_berobat' => ['required', 'in:Ya,Tidak'],
            'tanggal' => ['required', 'date'],
            'no_antrian' => ['required', 'integer', 'min:1'],
        ], [
            'nik.regex' => 'NIK harus 16 digit angka.',
        ]);

        $history->update($validated);

        return redirect()
            ->route('admin.patientsHistory.indexAdmin')
            ->with('success', 'Riwayat pasien berhasil diperbarui.');
    }

    public function destroyAdmin($id_history)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                             ->withErrors('You are not authorized to access this page');
        }

        $history = PatientHistory::findOrFail($id_history);
        $history->delete();

        return redirect()->route('admin.patientsHistory.indexAdmin')
                         ->with('success', 'Riwayat pasien berhasil dihapus.');
    }
}
