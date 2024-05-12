<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\Request;


class HomeController extends Controller
{

    public function index()
    {
        $domainName = 'https://'.Request::getHttpHost() . '/api';

        return view('welcome', compact('domainName'));
    }

    public function test(\Illuminate\Http\Request $request)
    {
        return $request->post('');
    }

}
