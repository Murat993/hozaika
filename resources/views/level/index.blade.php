<?php
/**
 * @var $models \App\Models\Level[]
 */
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">Уровни</h3>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="{{route('levels.create')}}">Добавить</a>
    <div class="card card-default">
        <div class="card-body">
            <table class="table">
                <thead class="thead-inverse">
                <tr>
                    <th>Название М</th>
                    <th>Название Ж</th>
                </tr>
                </thead>
                <tbody>
                @foreach($models as $item)
                    <tr>
                        <td>{{$item->name_man}}</td>
                        <td>{{$item->name_woman}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
