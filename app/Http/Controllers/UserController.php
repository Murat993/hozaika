<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Models\Level;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $models = User::whereJsonContains('roles', User::ROLE_USER)->paginate(30);
        return view('user.index', compact('models'));
    }

    public function create()
    {
        $model = new User();
        $genders = User::GENDERS;
        return view('user.create', compact('model', 'genders'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->only(['firstname', 'lastname', 'email', 'gender']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request['password']);
        }
        $data['roles'] = [User::ROLE_USER];
        $data['level_id'] = Level::orderBy('id')->first()->id;

        User::create($data);

        UserLog::create([
            'user_id' => auth()->id(),
            'description' => 'Создан пользователь',
            'event' => UserLog::EVENT_USER_CREATE,
            'new_value' => $data,
        ]);

        return redirect(route('users.index'));
    }

    public function edit($id)
    {
        $model = User::findOrFail($id);
        $genders = User::GENDERS;
        return view('user.create', compact('model', 'genders'));
    }

    public function update(UserRequest $request, $id)
    {
        $model = User::findOrFail($id);
        $oldValue = $model->toArray();

        $data = $request->only(['firstname', 'lastname', 'email', 'gender']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request['password']);
        }

        $model->update($data);

        UserLog::create([
            'user_id' => auth()->id(),
            'description' => 'Обновлен пользователь',
            'event' => UserLog::EVENT_USER_UPDATE,
            'old_value' => $oldValue,
            'new_value' => $data,
        ]);

        return redirect(route('users.index'));
    }

    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $oldValue = $model->toArray();
        $model->delete();

        UserLog::create([
            'user_id' => auth()->id(),
            'description' => 'Удален пользователь',
            'event' => UserLog::EVENT_USER_DELETE,
            'old_value' => $oldValue,
        ]);

        return redirect(route('users.index'));
    }
}
