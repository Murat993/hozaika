<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoyaltyController
{
    public function index(Request $request)
    {
        $user = User::find($request->user()->id);
        return view('user.loyalty', compact('user'));
    }
}
