@extends('layouts.app')

@section('content')
    <div class="container-loyalty mt-5">
        <img src="/logo.png" alt="Логотип" class="img-fluid logo">
        <div class="container-loyalty-wrap">
            <h5 style="font-size: 16px;" class="text-muted">Добро пожаловать в систему лояльности Хозяйка</h5>
            <h3 style="font-size: 16px;margin-bottom: 20px" class="">{{ $user->getFullName() }}</h3>
            <h6 style="font-size: 13px;" class="text-muted">Сумма ваших покупок</h6>
            <h1 style="font-size: 28px;font-weight: bold;margin-bottom: 20px" class="">{{$productsSum}} тенге</h1>
            <div class="">
                <span>Текущий уровень: <strong class="text-primary">{{$levelName}}</strong></span>
            </div>
            <div class="progress my-4">
                <div class="progress-bar progress-bar-custom" role="progressbar" style="width: {{$progressPercentage}}%;" aria-valuenow="{{$progressPercentage}}" aria-valuemin="0" aria-valuemax="100">{{$progressPercentage}}% из 100%</div>
            </div>
            <h6 class="loyalty-text-font-size">Выполните для перехода на следующий уровень:</h6>
            <ul class="task-list">
                @foreach($levelTasks as $task)
                    <li class="{{ in_array($task->id, $completedTasks) ? 'task-completed' : 'task-pending' }}">
                        <i class="fa {{ in_array($task->id, $completedTasks) ? 'fa-check' : 'fa-square' }}"></i>
                        <span>{{ $task->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
@endsection
