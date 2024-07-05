@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0 text-dark">Добавить товар для {{$user->getFullName()}}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-body">
                <form method="POST" action="{{ route('users.products.store', $user->id) }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="amount">Сумма</label>
                            <input type="text" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="link">Ссылка</label>
                            <input type="text" class="form-control" id="link" name="link" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">Комментарий</label>
                        <textarea class="form-control" id="comment" name="comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>

        <div class="card card-default mt-4">
            <div class="card-body">
                <h4>Товары пользователя</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Сумма</th>
                        <th>Ссылка</th>
                        <th>Комментарий</th>
                        <th>Дата добавления</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->amount }}</td>
                            <td class="link-column-add-product"><a href="{{ $product->link }}" target="_blank">{{ $product->link }}</a></td>
                            <td>{{ $product->comment }}</td>
                            <td>{{ $product->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
@endsection
