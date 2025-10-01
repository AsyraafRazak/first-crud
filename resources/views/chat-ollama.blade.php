@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ollama Chat</h2>

    <div class="card mt-4">
        <div class="card-header">
            <strong>Model:</strong> {{ $data['model'] ?? 'Unknown' }}
        </div>
        <div class="card-body">
            <p><strong>Prompt:</strong> "Hello, how are you?"</p>
            <hr>
            <h5>Response:</h5>
            <div class="p-3 border rounded bg-light" style="white-space: pre-wrap;">
                {{ $data['response'] ?? 'No response' }}
            </div>
        </div>
        <div class="card-footer text-muted">
            <small>Generated at: {{ \Carbon\Carbon::parse($data['created_at'])->toDayDateTimeString() }}</small>
        </div>
    </div>
</div>
@endsection
