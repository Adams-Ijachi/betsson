<?php

namespace App\Action\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GetUserTodosAction
{

    /**
     * Create a user
     * @param User $user
     * @param Request $request
     * @return LengthAwarePaginator
     */
    final function execute(User $user,Request $request): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Todo::query()
            ->when($request->input('priority'), function (Builder $query, $priority){
                $query->where('priority_id',$priority);
            })
            ->when($request->input('category'), function (Builder $query, $category){
                $query->where('category_id',$category);
            })
            ->whereNull('parent_id')
            ->where('user_id', $user->id)
            ->where('is_completed', false)
            ->orderByDesc('created_at')
            ->paginate(5)
            ->withQueryString();

    }

}