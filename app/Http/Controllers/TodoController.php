<?php

namespace App\Http\Controllers;

use App\Action\Todo\CreateUserTodoAction;
use App\Action\Todo\GetUserTodosAction;
use App\Action\Todo\UpdateTodoStatusAction;
use App\Enums\NotificationTypeEnum;
use App\Http\Requests\CreateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Todo;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TodoController extends Controller
{
    public function show(GetUserTodosAction $getTodosAction, Request $request): \Inertia\Response
    {
        $user = Auth::user();

        $allUserTodos = Todo::query()
            ->select('id','name')
            ->where('is_completed',false)
            ->where('user_id', $user->id)
            ->orderByDesc('created_at');

        $todos = $getTodosAction->execute($user,$request);

        return Inertia::render('Todo',[
            'todos' => TodoResource::collection($todos),
            'labels' => Category::all(),
            'all_users_todos' => $allUserTodos->get(),
            'priorities' => Priority::all()
        ]);
    }


    public function create(CreateUserTodoAction $createUserTodoAction, CreateTodoRequest $createTodoRequest): RedirectResponse
    {
        $user = Auth::user();

        $createUserTodoAction->execute($user,$createTodoRequest->validated());

        return redirect()->route('home')->with('toasts', [
            'message' => "Task created",
            'type' => NotificationTypeEnum::SUCCESS
        ]);
    }

    /**
     * @throws Exception
     */
    public function update(Todo $todo, UpdateTodoStatusAction $updateTodoStatusAction, Request $request): RedirectResponse
    {
        $updateTodoStatusAction->execute($todo);

        return redirect()->back()->with('toasts', [
            'message' => "Task Marked As Done",
            'type' => NotificationTypeEnum::SUCCESS
        ]);

    }


}
