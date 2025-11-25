<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    public function indexAdmin(Request $request)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                ->withErrors('You are not authorized to access this page');
        }

        $pagination = $this->resolvePerPage($request);
        $perPage = $pagination['perPage'];
        $perPageOptions = $pagination['options'];

        $query = Information::orderBy('created_at', 'desc');

        $infos = $perPage === 'all'
            ? $query->get()
            : $query->paginate($perPage)->appends($request->except('page'));

        return view('admin.informations.index', compact('infos', 'perPage', 'perPageOptions'));
    }

    public function createAdmin()
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                ->withErrors('You are not authorized to access this page');
        }

        return view('admin.informations.create');
    }

    public function storeAdmin(Request $request)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                ->withErrors('You are not authorized to access this page');
        }

        $validated = $request->validate([
            'jenis' => 'required|string|max:50',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $coverName = null;
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $coverName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/covers', $coverName);
        }

        Information::create([
            'jenis' => $validated['jenis'],
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'cover' => $coverName,
        ]);

        return redirect()->route('admin.informations.indexAdmin')
            ->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function editAdmin($id_informasi)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                ->withErrors('You are not authorized to access this page');
        }

        $info = Information::findOrFail($id_informasi);
        return view('admin.informations.edit', compact('info'));
    }

    public function updateAdmin(Request $request, $id_informasi)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                ->withErrors('You are not authorized to access this page');
        }

        $info = Information::findOrFail($id_informasi);

        $validated = $request->validate([
            'jenis' => 'required|string|max:50',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($info->cover && Storage::exists('public/covers/' . $info->cover)) {
                Storage::delete('public/covers/' . $info->cover);
            }

            $file = $request->file('cover');
            $coverName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/covers', $coverName);
            $info->cover = $coverName;
        }

        $info->jenis = $validated['jenis'];
        $info->judul = $validated['judul'];
        $info->isi = $validated['isi'];
        $info->save();

        return redirect()->route('admin.informations.indexAdmin')
            ->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroyAdmin($id_informasi)
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            return redirect()->route('dashboard')
                ->withErrors('You are not authorized to access this page');
        }

        $info = Information::findOrFail($id_informasi);

        if ($info->cover && Storage::exists('public/covers/' . $info->cover)) {
            Storage::delete('public/covers/' . $info->cover);
        }

        $info->delete();

        return redirect()->route('admin.informations.indexAdmin')
            ->with('success', 'Informasi berhasil dihapus.');
    }

    public function show(Information $information)
    {
        return view('informations.show', [
            'info' => $information,
        ]);
    }
}
