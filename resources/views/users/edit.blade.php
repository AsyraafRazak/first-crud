@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Users Edit') }}</span>
                        <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="bi bi-x-lg"></i></i></a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $user->email }}" required>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
