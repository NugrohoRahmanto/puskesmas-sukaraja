<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function me()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function editMe()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function updateMe(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username'     => [
                'required','string','max:50','alpha_dash',
                Rule::unique('users','username')->ignore($user->id_pengguna, 'id_pengguna')
            ],
            'email'        => [
                'required','email','max:255',
                Rule::unique('users','email')->ignore($user->id_pengguna, 'id_pengguna')
            ],
            'nama_lengkap' => 'required|string|max:255',
            'no_tel'       => 'nullable|string|max:15',
        ]);

        $user->update([
            'username'     => $validated['username'],
            'email'        => $validated['email'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'no_tel'       => $validated['no_tel'] ?? null,
        ]);

        return redirect()->route('user.me')->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword()
    {
        return view('users.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required','current_password'],
            'new_password'     => ['required','string','min:8','different:current_password','confirmed'],
        ]);

        $user->forceFill([
            'password' => Hash::make($request->new_password),
        ])->save();

        return redirect()->route('user.me')->with('success', 'Password berhasil diperbarui.');
    }

    public function indexAdmin(Request $request)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->withErrors('You are not authorized to access this page');
        }
        $pagination = $this->resolvePerPage($request);
        $perPage = $pagination['perPage'];
        $perPageOptions = $pagination['options'];

        $query = User::orderBy('nama_lengkap');

        $users = $perPage === 'all'
            ? $query->get()
            : $query->paginate($perPage)->appends($request->except('page'));

        return view('admin.users.index', compact('users', 'perPage', 'perPageOptions'));
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
