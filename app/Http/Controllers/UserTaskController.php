<?php

namespace App\Http\Controllers;

use App\Models\CompletedUserTask;
use App\Models\Task;
use App\Models\User;
use App\Models\UserLog;
use App\Services\UserLogService;
use Illuminate\Http\Request;

class UserTaskController extends Controller
{
    public function __construct(private readonly UserLogService $userLogService)
    {
    }

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

        $this->userLogService->create(
            'Выполнена задача у пользователя ' . $user->getFullName(),
            UserLog::EVENT_COMPLETE_TASK,
            $completeUserTask->toArray()
        );

        $user->promoteToNextLevel();

        return redirect()->route('users.tasks', $user->id)->with('success', 'Задача успешно выполнена');
    }
}
