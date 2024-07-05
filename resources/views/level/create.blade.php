@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0 text-dark">Создание уровня</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-body">
                <form name="users-create-edit"
                      action="{{route('levels.store')}}"
                      enctype="multipart/form-data"
                      method="post">
                    @method('post')
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
                    <div class="form-group{{ $errors->has('name_man') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="name_man" class="col-md-4 control-label">Название Муж.</label>
                            <div class="col-md-6">
                                <input type="text" id="name_man" name="name_man" value="{{$model->name_man ?? old('name_man')}}"
                                       class="form-control">

                                @if ($errors->has('name_man'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name_man') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('name_woman') ? ' has-error' : '' }}">
                        <div class="row">
                            <label for="name_woman" class="col-md-4 control-label">Название Жен.</label>
                            <div class="col-md-6">
                                <input type="text" id="name_woman" name="name_woman" value="{{$model->name_woman ?? old('name_woman')}}"
                                       class="form-control">

                                @if ($errors->has('name_woman'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name_woman') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">{{trans('Создать')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
