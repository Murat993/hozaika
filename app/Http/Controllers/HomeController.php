<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Request;


class HomeController extends Controller
{

    public function index()
    {
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@mail.ru',
            'password' => bcrypt('123123'),
        ]);
        var_dump('asdasd0');die();

        return view('welcome', compact('domainName'));
    }
}
