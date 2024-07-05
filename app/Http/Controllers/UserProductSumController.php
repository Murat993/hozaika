<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProductSumRequest;
use App\Models\CompletedUserTask;
use App\Models\User;
use App\Models\UserLog;
use App\Models\UserProductSum;
use Illuminate\Http\Request;

class UserProductSumController extends Controller
{
    public function index(User $user)
    {
        $products = $user->productsSum()->paginate(30);
        return view('user.products.index', compact('user', 'products'));
    }

    public function store(UserProductSumRequest $request, User $user)
    {
        $product = UserProductSum::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'link' => $request->link,
            'comment' => $request->comment,
        ]);

        UserLog::create([
            'user_id' => auth()->id(),
            'description' => 'Добавлен новый товар для пользователя ' . $user->getFullName(),
            'event' => UserLog::EVENT_ADD_PRODUCT_SUM,
            'new_value' => $product->toArray(),
        ]);

        $purchaseAmount = $user->level->tasks()->sum('purchase_amount');
        $amount = $user->productsSum()->sum('amount');

        foreach ($user->level->tasks as $task) {
            if ($purchaseAmount > $amount) {
                continue;
            }
            CompletedUserTask::firstOrCreate([
                'user_id' => $user->id,
                'task_id' => $task->id,
            ]);
        }

        $user->promoteToNextLevel();

        return redirect()->route('users.products.index', $user)->with('success', 'Товар успешно добавлен');
    }
}
