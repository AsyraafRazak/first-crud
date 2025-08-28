@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Inventories Index') }}</span>
                        <a href="{{ route('inventories.create') }}" class="btn btn-success btn-sm">
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
                                    <th>User</th>
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
                                        {{-- ni kalau nak tarik dari database lain --}}
                                        <td>{{ $inventory->user->id }} - {{ $inventory->user->name }}</td>
                                        <td>
                                            @can('view', $inventory)
                                                {{-- kalau takde policy dia error 403 --}}
                                                <a href="{{ route('inventories.show', $inventory) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                            @endcan
                                            @can('update', $inventory)
                                                <a href="{{ route('inventories.edit', $inventory) }}"
                                                    class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                                {{-- <a onclick="return confirm('Delete {{ $inventory->name }} tau')"
                                                href="{{ route('inventories.destroy', $inventory) }}"
                                                class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a> --}}
                                            @endcan
                                            <form action="{{ route('inventories.destroy', $inventory) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Delete {{ $inventory->name }}') || event.preventDefault();"
                                                    type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i></a>
                                            </form>
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
