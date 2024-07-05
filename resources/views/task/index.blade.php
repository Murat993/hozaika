@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Задачи</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a class="btn btn-primary mb-3" href="{{ route('tasks.create') }}">Добавить задачу</a>
        <div class="card card-default">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Уровень</th>
                        <th>Название</th>
                        <th>Сумма покупки</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->level->name_man }} / {{ $task->level->name_woman }}</td>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->purchase_amount }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('tasks.edit', $task->id) }}">Редактировать</a>
                                <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $tasks->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
