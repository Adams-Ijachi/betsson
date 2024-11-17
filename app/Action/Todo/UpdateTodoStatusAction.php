<?php

namespace App\Action\Todo;

use App\Models\Todo;


class UpdateTodoStatusAction
{

    /**
     * @throws \Exception
     */
    final function execute(Todo $parentTodo): void
    {
        try {
            $todos = $parentTodo->children()->get();
            $parentTodo->is_completed = true;
            $parentTodo->save();

            foreach ($todos as $todo){
                $this->execute($todo);
            }

        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }



    }

}