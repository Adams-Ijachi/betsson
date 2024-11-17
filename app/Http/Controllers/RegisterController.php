<?php

namespace App\Http\Controllers;

use App\Action\RegisterUserAction;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show(Request $request)
    {
        return view('auth.register');
    }

    public function create(RegisterUserAction $registerUserAction,RegisterUserRequest $request)
    {
        $user = $registerUserAction->execute($request->validated());

        Auth::login($user);

        return redirect()->route('home')->with('status', 'Profile updated!');
    }
}
