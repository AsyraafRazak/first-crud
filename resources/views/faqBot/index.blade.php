@extends('layouts.staffLayout')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">Chatbot</div>
                <div class="card-body">
                    <div id="chat-box" class="mb-3 p-3 border rounded" style="height: 300px; overflow-y: auto;">
                        <!-- Messages will appear here -->
                    </div>
                    <form id="chat-form">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="message" name="message" class="form-control"
                                   placeholder="Ask about staff info...">
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('chat-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    let message = document.getElementById('message').value;

    // show user message
    let chatBox = document.getElementById('chat-box');
    chatBox.innerHTML += `<div><strong>You:</strong> ${message}</div>`;

    let response = await fetch("{{ route('chat.send') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ message })
    });

    let data = await response.json();
    chatBox.innerHTML += `<div><strong>Bot:</strong> ${data.bot}</div>`;
    chatBox.scrollTop = chatBox.scrollHeight; // auto scroll
    document.getElementById('message').value = '';
});
</script>
@endsection