@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0 text-dark">Создание/Редактирование пользователя</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-body">
                <form name="users-create-edit"
                      action="@if($model->exists){{route('users.update', $model->id)}}@else{{route('users.store')}}@endif"
                      enctype="multipart/form-data"
                      method="post">
                    @if($model->exists)
                        @method('put')
                    @else
                        @method('post')
                    @endif
                    @csrf
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="firstname" class="col-md-4 control-label">Имя пользователя</label>
                            <div class="col-md-6">
                                <input type="text" id="firstname" name="firstname" value="{{$model->firstname ?? old('firstname')}}"
                                       class="form-control">

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="lastname" class="col-md-4 control-label">Фамилия пользователя</label>
                            <div class="col-md-6">
                                <input type="text" id="lastname" name="lastname" value="{{$model->lastname ?? old('lastname')}}"
                                       class="form-control">

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="email" class="col-md-4 control-label">Емейл</label>
                            <div class="col-md-6">
                                <input type="text" id="email" name="email" value="{{$model->email ?? old('email')}}"
                                       class="form-control">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="gender" class="col-md-4 control-label">Пол</label>
                            <div class="col-md-6">
                                <select id="gender" name="gender" class="form-control">
                                    @foreach($genders as $key => $value)
                                        <option value="{{ $key }}" {{ ($model->gender ?? old('gender')) == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="password" class="col-md-4 control-label">Пароль</label>
                            <div class="col-md-6">
                                <input type="text" id="password" name="password"
                                       class="form-control">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($model->exists)
                        <button type="submit" class="btn btn-success">{{trans('Редактировать')}}</button>
                    @else
                        <button type="submit" class="btn btn-success">{{trans('Создать')}}</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
