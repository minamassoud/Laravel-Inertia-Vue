<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthenticateAction;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthenticateController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('Auth/Login', [
            'status' => $request->session()->get('status')
        ]);
    }

    public function store(Request $request, AuthenticateAction $action)
    {

        if ($action->login($request->all())) {

            $request->session()->regenerate();

            return redirect()->intended('dashboard');

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
