<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus @gmail.com.',
            'email.exists' => 'Credentials Not Valid.',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                if ($user->getRoleNames()[0] === 'Admin') {
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('home');
                }
            } else {
                return back()->with('message', 'Email/Password Salah.');
            }
        } else {
            return back()->with('message', 'Akun tidak terdaftar.');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->route('home');
    }
}
