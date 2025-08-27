@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Inventories Create') }}</span>
                        <a href="{{ route('inventories.index') }}" class="btn btn-danger"><i class="bi bi-x-lg"></i></i></a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>

                            <button type="submit" class="btn btn-success"><i class="bi bi-plus-lg"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
