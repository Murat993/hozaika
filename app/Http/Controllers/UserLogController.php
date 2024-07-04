<?php

namespace App\Http\Controllers;

use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Models\User;

class UserLogController extends Controller
{
    public function index(Request $request)
    {
        $query = UserLog::query();

        if ($request->filled('manager_id')) {
            $query->where('user_id', $request->input('manager_id'));
        }

        $logs = $query->paginate(50);
        $managers = User::whereJsonContains('roles', User::ROLE_MANAGER)->pluck('firstname', 'id');

        return view('logs.index', compact('logs', 'managers'));
    }
}
