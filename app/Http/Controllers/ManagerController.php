<?php

namespace App\Http\Controllers;


use App\Http\Requests\ManagerRequest;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $models = User::whereJsonContains('roles', User::ROLE_MANAGER)->paginate(30);
        return view('manager.index', compact('models'));
    }

    public function create()
    {
        $model = new User();
        return view('manager.create', compact('model'));
    }

    public function store(ManagerRequest $request)
    {
        $data = $request->only(['firstname', 'lastname', 'email']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request['password']);
        }
        $data['roles'] = [User::ROLE_MANAGER];

        User::create($data);

        UserLog::create([
            'user_id' => auth()->id(),
            'description' => 'Создан менеджер',
            'event' => UserLog::EVENT_MANAGER_CREATE,
            'new_value' => $data,
        ]);

        return redirect(route('admin.managers.index'));
    }

    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('manager.create', compact('model'));
    }

    public function update(ManagerRequest $request, $id)
    {
        $model = User::findOrFail($id);
        $oldValue = $model->toArray();

        $data = $request->only(['firstname', 'lastname', 'email']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request['password']);
        }

        $model->update($data);

        UserLog::create([
            'user_id' => auth()->id(),
            'description' => 'Создан менеджер',
            'event' => UserLog::EVENT_MANAGER_UPDATE,
            'old_value' => $oldValue,
            'new_value' => $data,
        ]);

        return redirect(route('admin.managers.index'));
    }

    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $oldValue = $model->toArray();
        $model->delete();

        UserLog::create([
            'user_id' => auth()->id(),
            'description' => 'Удален менеджер',
            'event' => UserLog::EVENT_MANAGER_DELETE,
            'old_value' => $oldValue,
        ]);

        return redirect(route('admin.managers.index'));
    }
}
