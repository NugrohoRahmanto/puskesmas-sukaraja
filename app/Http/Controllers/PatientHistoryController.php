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

    public function indexAdmin(Request $request)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                             ->withErrors('You are not authorized to access this page');
        }

        $filters = $request->validate([
            'start_date' => ['nullable','date'],
            'end_date'   => ['nullable','date','after_or_equal:start_date'],
        ]);

        $pagination = $this->resolvePerPage($request);
        $perPage = $pagination['perPage'];
        $perPageOptions = $pagination['options'];

        $historiesQuery = PatientHistory::orderBy('tanggal', 'desc');

        if (!empty($filters['start_date'])) {
            $historiesQuery->whereDate('tanggal', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $historiesQuery->whereDate('tanggal', '<=', $filters['end_date']);
        }

        $histories = $perPage === 'all'
            ? $historiesQuery->get()
            : $historiesQuery->paginate($perPage)->appends($request->except('page'));

        return view('admin.patientsHistory.index', [
            'histories' => $histories,
            'filters'   => $filters,
            'perPage'   => $perPage,
            'perPageOptions' => $perPageOptions,
        ]);
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
            'gender' => ['required','in:Laki-laki,Perempuan'],
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
