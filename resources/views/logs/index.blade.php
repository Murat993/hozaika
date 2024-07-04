@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0 text-dark">Логи</h3>
                    </div>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.logs.index') }}" class="mb-3">
            <div class="form-row">
                <div class="col-md-4">
                    <select name="manager_id" class="form-control">
                        <option value="">Выберите менеджера</option>
                        @foreach($managers as $id => $name)
                            <option value="{{ $id }}" {{ request('manager_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Фильтровать</button>
                </div>
            </div>
        </form>

        <div class="card card-default">
            <div class="card-body">
                <table class="table">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Пользователь</th>
                        <th>Описание</th>
                        <th class="value-column">Старое значение</th>
                        <th class="value-column">Новое значение</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->user->getFullName() }}</td>
                            <td style="font-size: 12px">{{ $log->description }}</td>
                            <td class="value-log-column">
                                @if($log->old_value)
                                    <pre>{{ $log->formatValues($log->old_value) }}</pre>
                                @endif
                            </td>
                            <td class="value-log-column">
                                @if($log->new_value)
                                    <pre>{{ $log->formatValues($log->new_value) }}</pre>
                                @endif
                            </td>
                            <td style="font-size: 12px">{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-10">
            <div class="form-group">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
