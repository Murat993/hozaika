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
                    <h3 class="m-0 text-dark">Менеджеры</h3>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="{{route('managers.create')}}">Добавить</a>
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
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{route('managers.edit', $item->id)}}">
                                Редактировать</a>
                        </td>
                        <td>
                            <form style="display:inline;" method="POST" action="{{ route('managers.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Удалить</button>
                            </form>
                        </td>
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
