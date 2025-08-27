@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Vehicles Index') }}</span>
                        <a href="{{ route('vehicle.create') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vehicles as $vehicle)
                                        <tr>
                                            <td>{{ $vehicle->id }}</td>
                                            <td>{{ $vehicle->name }}</td>
                                            <td>{{ $vehicle->qty}}</td>
                                            {{-- <td><a href="{{ route('vehicle.show', $vehicle) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('vehicle.show', $vehicle) }}"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                                <a onclick="return confirm('Delete tau')"
                                                    href="{{ route('vehicle.destroy', $vehicle) }}"
                                                    class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
