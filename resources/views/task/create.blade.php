@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Добавить задачу</h3>

        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="form-group">
                <label for="level_id">Уровень</label>
                <select class="form-control" id="level_id" name="level_id" required>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name_man }} / {{ $level->name_woman }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="purchase_amount">Сумма покупки</label>
                <input type="text" class="form-control" id="purchase_amount" name="purchase_amount">
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>
@endsection
