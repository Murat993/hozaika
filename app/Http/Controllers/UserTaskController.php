<?php

namespace App\Http\Controllers;

use App\Models\CompletedUserTask;
use App\Models\Task;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;

class UserTaskController extends Controller
{
    public function index(User $user)
    {
        $levelTasks = $user->level->tasks;
        $completedTasks = $user->completedUserTasks->pluck('task_id')->toArray();
        $productsSum = $user->productsSum()->sum('amount');

        return view('user.tasks.index', compact('user', 'levelTasks', 'completedTasks', 'productsSum'));
    }

    public function completeTask(Request $request, User $user, Task $task)
    {
        $completeUserTask = CompletedUserTask::create([
            'user_id' => $user->id,
            'task_id' => $task->id,
        ]);

        UserLog::create([
            'user_id' => auth()->id(),
            'description' => 'Выполнена задача у пользователя ' . $user->getFullName(),
            'event' => UserLog::EVENT_COMPLETE_TASK,
            'new_value' => $completeUserTask->toArray(),
        ]);

        $user->promoteToNextLevel();

        return redirect()->route('users.tasks', $user->id)->with('success', 'Задача успешно выполнена');
    }
}
