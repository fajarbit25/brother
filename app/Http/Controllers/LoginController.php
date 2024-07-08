<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /**Halaman Login */
    public function index(): View
    {
        return view('auth.index');
    }

    /**Proses Authentication */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return response(['auth' => 'true']);
        }

        return response(['auth' => 'fails']);
    }

    /**Proses Logout */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response(['logout' => 'true']);
    }
}
