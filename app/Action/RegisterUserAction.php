<?php

namespace App\Action;

use App\Models\User;

class RegisterUserAction
{

    /**
     * Create a user
     * @param array $validatedData
     * @return User
     */
    final function execute(array $validatedData): User
    {
        $user = new User();

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];

        $user->save();

        return $user;

    }
}