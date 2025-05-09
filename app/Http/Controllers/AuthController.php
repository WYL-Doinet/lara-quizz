<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function signIn(Request $request)
    {

        if ($request->isMethod('get')) {
            return Inertia::render('Auth/SignIn');
        }

        if ($request->isMethod('post')) {
            $email = $request->input('email');
            $password = $request->input('password');

            $credentials = [
                'email' => $email,
                'password' => $password,
            ];

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('home'));
            }

            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email');
        }
    }

    public function signOut()
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('auth.signIn');
    }
}
