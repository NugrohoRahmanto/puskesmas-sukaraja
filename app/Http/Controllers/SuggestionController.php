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

    public function create()
    {
        return view('suggestions.create');
    }

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

    public function indexAdmin(Request $request)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $pagination = $this->resolvePerPage($request);
        $perPage = $pagination['perPage'];
        $perPageOptions = $pagination['options'];

        $query = Suggestion::with('user')->orderBy('created_at', 'desc');

        $suggestions = $perPage === 'all'
            ? $query->get()
            : $query->paginate($perPage)->appends($request->except('page'));

        return view('admin.suggestions.index', compact('suggestions', 'perPage', 'perPageOptions'));
    }

    public function editAdmin($id_saran)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $suggestion = Suggestion::findOrFail($id_saran);
        return view('admin.suggestions.edit', compact('suggestion'));
    }

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
