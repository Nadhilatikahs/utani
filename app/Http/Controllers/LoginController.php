<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Iluminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected function loggedOut(Request $request)
{
    return redirect('/login');
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}
}
