<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudstudio\Ollama\Facades\Ollama;
use App\Models\Staff;

class faqBotController extends Controller
{
    public function index()
    {
        return view('faqBot.index'); // load the Blade view
    }

    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        $prompt = <<<PROMPT
You are a strict JSON generator.
Take the user question and output ONLY valid JSON. No explanations, no markdown, no extra text.

Examples:
User: Who is Ali?
{"action": "find_staff", "name": "Ali"}

User: How many staff in HR?
{"action": "count_department", "department": "HR"}

User: List staff in IT
{"action": "list_department", "department": "IT"}

Now process this:
{$userMessage}

IMPORTANT: Reply with ONLY valid JSON. Do not include words, explanations, or formatting.
PROMPT;

        $response = Ollama::prompt($prompt)
            ->model('gemma3:1b')
            ->ask();

        $raw = $response['response'] ?? '';
        
        // 🔎 Debug: log the raw response
        \Log::info('Ollama raw response: ' . $raw);

        $json = json_decode(trim($raw), true);

        $botReply = "Sorry, I couldn’t understand your request.";

        // 2. If JSON is valid, map actions → DB queries
        if ($json && isset($json['action'])) {
            switch ($json['action']) {
                case 'find_staff':
                    $staff = Staff::where('name', 'like', "%{$json['name']}%")->first();
                    $botReply = $staff
                        ? "I found {$staff->name}, working as {$staff->position} in {$staff->department}. Contact: {$staff->email}, Phone: {$staff->phone}."
                        : "No staff found with name {$json['name']}.";
                    break;

                case 'count_department':
                    $count = Staff::where('department', 'like', "%{$json['department']}%")->count();
                    $botReply = "There are {$count} staff in the {$json['department']} department.";
                    break;

                case 'list_department':
                    $staffs = Staff::where('department', 'like', "%{$json['department']}%")
                        ->pluck('name')->toArray();
                    $botReply = count($staffs)
                        ? "Staff in {$json['department']}: " . implode(', ', $staffs)
                        : "No staff found in {$json['department']}.";
                    break;
            }
        }

        // 3. Send final answer back to frontend
        return response()->json([
            'user' => $userMessage,
            'bot'  => $botReply,
        ]);
    }
}
