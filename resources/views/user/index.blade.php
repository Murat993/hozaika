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
    <a class="btn btn-primary" href="{{route('admin.users.create')}}">Добавить</a>
    <div class="card card-default">
        <div class="card-body">
            <table class="table">
                <thead class="thead-inverse">
                <tr>
                    <th>Название</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($models as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{route('admin.users.edit', $item->id)}}">
                                Редактировать</a>
                        </td>
                    </tr>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-10">
        <div class="form-group">
            {{ $models->links() }}
        </div>
    </div>
</div>
@endsection
