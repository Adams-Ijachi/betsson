<?php

namespace App\Action\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class CreateUserTodoAction
{

    final function execute(User $user,array $validatedData): void
    {
        $todo = new Todo();
        $todo->name = $validatedData['name'];
        $todo->priority_id = $validatedData['priority_id'];
        $todo->category_id = $validatedData['label_id'];
        $todo->parent_id = $validatedData['parent_id'];
        $todo->user_id = $user->id;

        $todo->save();

    }
}