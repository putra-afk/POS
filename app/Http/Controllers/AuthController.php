<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserModel;
use App\Models\LevelModel;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/'); // or route('dashboard')
        }

        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
            if ($request->ajax() || $request->wantsJson()) {
                $credentials = $request->only('username', 'password');

                if (Auth::attempt($credentials)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Successful',
                        'redirect' => route('welcome')
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Username atau password salah.'
            ]);
        }

        return redirect()->route('auth.login');
    }

    public function showRegisterForm()
    {
        $levels = LevelModel::all();
        return view('auth.register', compact('levels'));
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'level_id' => 'required|exists:m_level,level_id',
            'username' => 'required|unique:m_user,username|min:4|max:20',
            'nama' => 'required|min:3',
            'password' => 'required|min:6|max:20|confirmed',
        ]);

        $user = new UserModel();
        $user->level_id = $request->level_id;
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = bcrypt($request->password);
        $user->save();

        // Respond with success message
        return response()->json([
            'status' => true,
            'message' => 'Registration successful!',
            'redirect' => route('auth.login')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}
