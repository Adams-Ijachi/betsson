<?php

use App\Action\Todo\CreateUserTodoAction;
use App\Action\Todo\GetUserTodosAction;
use App\Action\Todo\UpdateTodoStatusAction;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


beforeEach(function () {
    $this->seed(\Database\Seeders\DatabaseSeeder::class);
});


test('Test a user get todos', function () {

    $user = User::first();
    $request = new Request();


    $todo = app(GetUserTodosAction::class)->execute( $user,$request);

    expect($todo->items())->toBeArray()
        ->toHaveCount(5);


});

test('Test a user todo can be created', function () {

    $user = User::first();
    $priority = Priority::first();
    $category = Category::first();
    $todo = Todo::first();

    $data = [
        'name' => "Test". Carbon::now()->day,
        'priority_id' => $priority->id,
        'label_id' => $category->id,
        'parent_id' => $todo->id,
    ];


     app(CreateUserTodoAction::class)->execute( $user,$data);

     \Pest\Laravel\assertDatabaseHas('todos',[
         'name' => "Test". Carbon::now()->day,
         'priority_id' => $priority->id,
         'category_id' => $category->id,
         'parent_id' =>  $todo->id,
         'is_completed' => 0
     ]);




});

test('Test a todo can be marked completed', function () {

    $user = User::first();

    $todo = Todo::query()
        ->where('is_completed',false)
        ->has('children')->first();


    app(UpdateTodoStatusAction::class)->execute($todo);

    verifyCompletedState($todo);

});

function verifyCompletedState($parentTodo): void
{
    $todos = $parentTodo->children()->get();
    expect( $parentTodo->is_completed)->toBeTrue();

    foreach ($todos as $todo){
        verifyCompletedState($todo);
    }
}