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
                      action="@if($model->exists){{route('admin.users.update', $model->id)}}@else{{route('admin.users.store')}}@endif"
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
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="name" class="col-md-4 control-label">Название</label>

                            <div class="col-md-6">
                                <input type="text" id="name" name="name" value="{{$model->name ?? old('name')}}"
                                       class="form-control">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="service_id" class="col-md-4 control-label">Статус</label>
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

