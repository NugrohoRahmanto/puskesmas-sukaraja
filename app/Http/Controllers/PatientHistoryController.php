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

    // Menampilkan form edit riwayat pasien
    public function editAdmin($id_history)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                             ->withErrors('You are not authorized to access this page');
        }

        $history = PatientHistory::findOrFail($id_history);
        return view('admin.patientsHistory.edit', compact('history'));
    }

    // Update riwayat pasien
    public function updateAdmin(Request $request, $id_history)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                             ->withErrors('You are not authorized to access this page');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'usia' => 'required|integer|min:0|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'no_tel' => 'nullable|string|max:15',
            'tanggal' => 'required|date',
        ]);

        $history = PatientHistory::findOrFail($id_history);
        $history->update($validated);

        return redirect()->route('admin.patientsHistory.indexAdmin')
                         ->with('success', 'Riwayat pasien berhasil diperbarui.');
    }

    // Hapus riwayat pasien
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
