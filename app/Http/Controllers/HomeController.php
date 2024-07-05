<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin() || $user->isManager()) {
            return redirect()->route('users.index');
        }  elseif ($user->isUser()) {
            return redirect()->route('user.loyalty');
        }

        return redirect('/login');
    }
}
