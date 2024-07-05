<?php

namespace App\Http\Controllers;


use App\Http\Requests\LevelRequest;
use App\Http\Requests\UserRequest;
use App\Models\Level;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        $models = Level::get();
        return view('level.index', compact('models'));
    }

    public function create()
    {
        $model = new Level();
        return view('level.create', compact('model'));
    }

    public function store(LevelRequest $request)
    {
        $data = $request->only(['name_man', 'name_woman']);

        Level::create($data);


        return redirect(route('levels.index'));
    }
}
