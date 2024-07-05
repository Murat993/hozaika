<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\CompletedUserTask;
use App\Models\Level;
use App\Models\User;
use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('level')->paginate(30);
        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('task.create', compact('levels'));
    }

    public function store(TaskRequest $request)
    {
        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана');
    }

    public function edit(Task $task)
    {
        $levels = Level::all();
        return view('task.edit', compact('task', 'levels'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена');
    }

    public function complete(Request $request, User $user, Task $task)
    {
        $userTask = CompletedUserTask::firstOrCreate([
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);
        $userTask->save();

        $user->promoteToNextLevel();

        return redirect()->route('users.tasks.index', $user)->with('success', 'Задача успешно выполнена');
    }
}
