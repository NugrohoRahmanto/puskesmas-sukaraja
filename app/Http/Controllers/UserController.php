<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function indexAdmin()
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function editAdmin($id_pengguna)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }
        $user = User::findOrFail($id_pengguna);
        return view('admin.users.edit', compact('user'));
    }

    public function updateAdmin(Request $request, $id_pengguna)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_tel'       => 'required|string|max:15',
            'status'       => 'required|in:active,inactive',
            'role'         => 'required|in:admin,user',
        ]);

        $user = User::findOrFail($id_pengguna);
        $user->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'no_tel'       => $validated['no_tel'],
            'status'       => $validated['status'],
            'role'         => $validated['role'],
        ]);

        return redirect()->route('admin.users.indexAdmin')->with('success', 'User updated successfully');
    }

    public function destroyAdmin($id_pengguna)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }

        $user = User::findOrFail($id_pengguna);
        $user->delete();

        return redirect()->route('admin.users.indexAdmin')->with('success', 'User deleted successfully');
    }
}
