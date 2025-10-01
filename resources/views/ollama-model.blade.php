@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Available Ollama Models</h2>

    @if(count($models) > 0)
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Family</th>
                    <th>Parameter Size</th>
                    <th>Quantization</th>
                    <th>Size (MB)</th>
                    <th>Modified At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($models as $model)
                    <tr>
                        <td>{{ $model['name'] }}</td>
                        <td>{{ $model['details']['family'] ?? '-' }}</td>
                        <td>{{ $model['details']['parameter_size'] ?? '-' }}</td>
                        <td>{{ $model['details']['quantization_level'] ?? '-' }}</td>
                        <td>{{ number_format($model['size'] / 1024 / 1024, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($model['modified_at'])->toDayDateTimeString() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning mt-3">No models found.</div>
    @endif
</div>
@endsection