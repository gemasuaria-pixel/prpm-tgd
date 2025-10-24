<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();

    //  Tambahin filter status
    if ($user->status !== 'approved') {
        Auth::logout(); // jangan biarin session nyangkut
        return back()->withErrors([
            'email' => 'Your account is not approved yet or has been rejected.',
        ]);
    }

    //  Cek role kayak biasa
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('dosen')) {
        return redirect()->route('dosen.dashboard');
    }
    if ($user->hasRole('ketua_prpm')) {
        return redirect()->route('ketua-prpm.dashboard');
    }
    if ($user->hasRole('reviewer')) {
        return redirect()->route('dashboard');
    }

    // fallback
    return redirect('/');
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
