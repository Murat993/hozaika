@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0 text-dark">Текущие уровень {{$user->level->name_man}}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-body">
                <table class="table">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Название задачи</th>
                        <th>Описание</th>
                        <th>Сумма покупки</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($levelTasks as $task)
                        <tr>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->purchase_amount }}</td>
                            <td>
                                @if(in_array($task->id, $completedTasks))
                                    <span class="badge badge-success">Завершил задачу</span>
                                @elseif(empty($task->purchase_amount))
                                    <form method="POST" action="{{ route('users.tasks.complete', ['user' => $user->id, 'task' => $task->id]) }}" onsubmit="return confirm('Вы уверены?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info">Завершить задачу</button>
                                    </form>
                                @else
                                    <div>
                                        Собрано: {{ $productsSum }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
