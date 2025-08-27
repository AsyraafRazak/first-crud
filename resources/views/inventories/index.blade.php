@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Inventories Index') }}</span>
                        <a href="{{ route('inventory.create') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventories as $inventory)
                                    <tr>
                                        <td>{{ $inventory->id }}</td>
                                        <td>{{ $inventory->name }}</td>
                                        <td>{{ $inventory->quantity }}</td>
                                        <td>{{ $inventory->description }}</td>
                                        <td><a href="{{ route('inventory.show', $inventory) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('inventory.show', $inventory) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            <a onclick="return confirm('Delete tau')"
                                                href="{{ route('inventory.destroy', $inventory) }}"
                                                class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                        </td>
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
