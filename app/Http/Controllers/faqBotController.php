<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Cloudstudio\Ollama\Facades\Ollama; // you can use this for the final generation
use App\Helpers\VectorHelper;
use App\Models\Staff;

class faqBotController extends Controller
{
    public function index()
    {
        return view('faqBot.index'); // load the Blade view
    }

    public function chat(Request $request)
    {
        try {
            $userMessage = $request->input('message');
            $ollamaUrl = config('ollama.url', env('OLLAMA_URL', 'http://127.0.0.1:11434'));
            $embedModel = 'nomic-embed-text'; // or nomic-embed-text, etc.

            // 1) Get embedding for the user query (try both endpoints)
            $resp = Http::post($ollamaUrl . '/api/embed', [
                'model' => $embedModel,
                'input' => $userMessage,
            ]);
            if ($resp->failed()) {
                $resp = Http::post($ollamaUrl . '/api/embeddings', [
                    'model' => $embedModel,
                    'prompt' => $userMessage,
                ]);
            }
            $data = $resp->json();

            // Extract embedding robustly
            $qEmbedding = $data['embedding'] ?? ($data['data'][0]['embedding'] ?? ($data['embeddings'][0] ?? null));
            if (!is_array($qEmbedding)) {
                \Log::error('Query embedding failed: ' . $resp->body());
                return response()->json(['user' => $userMessage, 'bot' => "Sorry, I couldn't create query embedding."]);
            }

            // 2) Load stored embeddings and score
            $rows = DB::table('staff_embeddings')->get();
            $scores = [];
            foreach ($rows as $row) {
                $vec = json_decode($row->embedding, true);
                $score = VectorHelper::cosineSimilarity($qEmbedding, $vec);
                $scores[] = ['staff_id' => $row->staff_id, 'score' => $score];
            }
            usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);
            $top = array_slice($scores, 0, 3);

            // 3) Build context
            $context = "Relevant staff records:\n";
            foreach ($top as $m) {
                $s = DB::table('staff')->find($m['staff_id']);
                if ($s) {
                    $context .= "- {$s->name}, {$s->position} in {$s->department}. Email: {$s->email}\n";
                }
            }

            // 4) Ask LLM (use Ollama facade or POST /api/generate)
            $prompt = <<<PROMPT
You are a staff assistant. Use only the following staff data to answer precisely:

$context

User question: {$userMessage}
PROMPT;

            $response = Ollama::prompt($prompt)
                ->model('gemma3:1b')
                ->ask();

            $botReply = $response['response'] ?? 'Sorry, no answer.';

            return response()->json(['user' => $userMessage, 'bot' => $botReply]);

        } catch (\Throwable $e) {
            \Log::error($e);
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
