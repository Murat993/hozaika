<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyController
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $productsSum = $user->productsSum()->sum('amount');
        $levelName = $user->gender === 'man' ? $user->level->name_man : $user->level->name_woman;

        $levelTasks = $user->level->tasks;
        $completedTasks = $user->completedUserTasks->pluck('task_id')->toArray();
        $completedCount = count($completedTasks);
        $totalTasks = $levelTasks->count();
        $progressPercentage = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100) : 0;

        return view('loyalty.index', compact('user', 'productsSum', 'levelName', 'levelTasks', 'completedTasks', 'progressPercentage'));
    }
}
