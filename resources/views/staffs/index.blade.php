@extends('layouts.staffLayout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Staffs Index') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                             <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Start Service Date</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Office Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $staff)
                                    <tr>
                                        <td>{{ $staff->id }}</td>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->gender }}</td>
                                        <td>{{ \Carbon\Carbon::parse($staff->startServiceDate)->format('d M Y') }}</td>
                                        <td>{{ $staff->position }}</td>
                                        <td>{{ $staff->department }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>{{ $staff->phone ?? '-' }}</td>
                                        <td>{{ $staff->office_location ?? '-' }}</td>
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
