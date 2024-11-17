<?php

namespace App\Action;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginUserAction
{


    /**
     * Create a user
     * @param array $validatedData
     * @return bool
     */
    final function execute(array $validatedData):bool
    {

        if (Auth::attempt($validatedData)) {
            Session::regenerate();
            return true;
        }
        return false;

    }
}