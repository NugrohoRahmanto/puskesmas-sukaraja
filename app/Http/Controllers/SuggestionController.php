<?php
namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    // Form tambah saran
    public function create()
    {
        return view('suggestions.create');
    }

    // Simpan saran
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:1000',
        ]);

        Suggestion::create([
            'id_pengguna' => Auth::id(),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dashboard')->with('success', 'Saran berhasil ditambahkan.');
    }

    // Tampilkan semua saran (admin)
    public function indexAdmin()
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $suggestions = Suggestion::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.suggestions.index', compact('suggestions'));
    }

    // Tampilkan form edit saran (admin)
    public function editAdmin($id_saran)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $suggestion = Suggestion::findOrFail($id_saran);
        return view('admin.suggestions.edit', compact('suggestion'));
    }

    // Update saran (admin)
    public function updateAdmin(Request $request, $id_saran)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $validated = $request->validate([
            'keterangan' => 'required|string|max:1000',
        ]);

        $suggestion = Suggestion::findOrFail($id_saran);
        $suggestion->update($validated);

        return redirect()->route('admin.suggestions.indexAdmin')->with('success', 'Saran berhasil diperbarui.');
    }

    // Hapus saran (admin)
    public function destroyAdmin($id_saran)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $suggestion = Suggestion::findOrFail($id_saran);
        $suggestion->delete();

        return redirect()->route('admin.suggestions.indexAdmin')->with('success', 'Saran berhasil dihapus.');
    }
}
