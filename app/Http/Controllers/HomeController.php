<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole(User::ROLE_ADMIN)) {
            return redirect()->route('admin.users.index');
        } elseif ($user->hasRole(User::ROLE_MANAGER)) {
            return view('manager.dashboard');
        } elseif ($user->hasRole(User::ROLE_USER)) {
            return redirect()->route('user.loyalty');
        }

        return redirect('/login');
    }
}
