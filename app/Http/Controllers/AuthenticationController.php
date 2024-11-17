<?php

namespace App\Http\Controllers;


use App\Action\LoginUserAction;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{

    /**
     * Handle an incoming authentication request.
     */
    public function show(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {

        return view('auth.login');

    }
    /**
     * Handle an incoming authentication request.
     * @throws ValidationException
     */
    public function store(LoginUserAction $loginUserAction,LoginRequest $request): \Illuminate\Http\RedirectResponse
    {

        $credentialsValid = $loginUserAction->execute($request->validated());

        if (!$credentialsValid){
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();
        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended('login');


    }
}
