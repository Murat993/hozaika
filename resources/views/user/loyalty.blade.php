<?php
/**
 * @var $user \App\Models\User
 */
?>
@extends('layouts.app')

@section('content')
    <div class="container container-loyalty mt-5">
        <div class="mb-4">
            <img src="/logo.png" alt="Логотип" class="img-fluid">
        </div>
        <h5 style="font-size: 16px;" class="text-muted">Добро пожаловать в систему лояльности Хозяйка</h5>
        <h3 style="font-size: 16px;margin-bottom: 20px" class="">{{ $user->getFullName() }}</h3>
        <h6 style="font-size: 13px;" class="text-muted">Сумма ваших покупок</h6>
        <h1 style="font-size: 28px;font-weight: bold;margin-bottom: 20px" class="">5990 тенге</h1>
        <div class="">
            <span>Текущий уровень: <strong class="text-primary">Новичок</strong></span>
        </div>
        <div class="progress my-4">
            <div class="progress-bar progress-bar-custom" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30% из 100%</div>
        </div>
        <h6 class="loyalty-text-font-size">Выполните для перехода на следующий уровень:</h6>
        <ul class="task-list">
            <li class="task-completed"><i class="fa fa-check"></i> <span>Сделать покупки на 50 000 тенге</span></li>
            <li class="task-completed"><i class="fa fa-check"></i> <span>Подтвердить личность</span></li>
            <li class="task-completed"><i class="fa fa-check"></i> <span>Написать отзыв в 2ГИС</span></li>
            <li class="task-pending"><i class="fa fa-square"></i> <span>Написать отзыв в 2ГИС</span></li>
            <li class="task-pending"><i class="fa fa-square"></i> <span>Написать отзыв в 2ГИС</span></li>
            <li class="task-pending"><i class="fa fa-square"></i> <span>Написать отзыв в 2ГИС</span></li>
            <li class="task-pending"><i class="fa fa-square"></i> <span>Написать отзыв в 2ГИС</span></li>
            <li class="task-pending"><i class="fa fa-square"></i> <span>Написать отзыв в 2ГИС</span></li>
        </ul>
    </div>
@endsection
