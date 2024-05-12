<?php


namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $models = User::paginate(30);
        return view('user.index', compact('models'));
    }

    public function create()
    {
        $model = new User();
        return view('user.create', compact('model'));
    }

    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request['name'],
            'status' => $request['status'],
        ]);

        return redirect(route('admin.users.index'));
    }

    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('user.create', compact('model'));
    }

    public function update(UserRequest $request, $id)
    {
        $model = User::findOrFail($id);

        $model->update([
            'name' => $request['name'],
            'status' => $request['status'],
        ]);

        return redirect(route('admin.users.index'));
    }

    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $model->delete();
        return redirect(route('admin.users.index'));
    }
}
