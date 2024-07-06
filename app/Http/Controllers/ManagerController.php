<?php

namespace App\Http\Controllers;


use App\Http\Requests\ManagerRequest;
use App\Models\User;
use App\Models\UserLog;
use App\Services\UserLogService;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function __construct(private readonly UserLogService $userLogService)
    {
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

        $this->userLogService->create('Создан менеджер', UserLog::EVENT_MANAGER_CREATE, $data);

        return redirect(route('managers.index'));
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

        $this->userLogService->create('Обновлен менеджер', UserLog::EVENT_MANAGER_UPDATE, $data, $oldValue);

        return redirect(route('managers.index'));
    }

    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $oldValue = $model->toArray();
        $model->delete();

        $this->userLogService->create('Удален менеджер', UserLog::EVENT_MANAGER_DELETE, null, $oldValue);

        return redirect(route('managers.index'));
    }
}
