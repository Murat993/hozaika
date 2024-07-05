<?php
/**
 * @var $models \App\Models\User[]
 */
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Пользователи</h3>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="{{route('users.create')}}">Добавить</a>
    <div class="card card-default">
        <div class="card-body">
            <table class="table">
                <thead class="thead-inverse">
                <tr>
                    <th>Имя</th>
                    <th>Емейл</th>
                </tr>
                </thead>
                <tbody>
                @foreach($models as $item)
                    <tr>
                        <td>{{$item->getFullName()}}</td>
                        <td>{{$item->email}}</td>
                        <td style="text-align: end;">
                            <a class="btn btn-sm btn-primary" href="{{route('users.edit', $item->id)}}">
                                Редактировать</a>
                            <a class="btn btn-sm btn-success" href="{{route('users.products.index', $item->id)}}">
                                Добавить товар</a>
                            <a class="btn btn-sm btn-info" href="{{route('users.tasks', $item->id)}}">
                                Текущие задачи</a>
                        @if (Auth::user()->isAdmin())
                            <form style="display:inline;" method="POST" action="{{ route('users.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Удалить</button>
                            </form>
                        @endif
                    </tr>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $models->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection
