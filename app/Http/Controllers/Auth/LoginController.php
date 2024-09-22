<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    /* protected $maxAttempts = 3;
    protected $decayMinutes = 1;

    public function __construct()
    {
        $this->middleware('throttle:' . $this->maxAttempts . ',' . $this->decayMinutes)->only('login');
    } */

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        return redirect('/');
    }
}
