<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->withErrors('Invalid credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:8|confirmed',
            'no_tel' => 'required|string|max:15',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_lengkap' => 'required|string|max:255',  
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'no_tel' => $request->no_tel, 
            'jenis_kelamin' => $request->jenis_kelamin, 
            'nama_lengkap' => $request->nama_lengkap, 
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
