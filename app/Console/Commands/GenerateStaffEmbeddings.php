<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Staff;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class GenerateStaffEmbeddings extends Command
{
    protected $signature = 'staff:embed';
    protected $description = 'Generate embeddings for staff and store them';

    public function handle()
    {
        $this->info('Generating staff embeddings...');
        $ollamaUrl = config('ollama.url', env('OLLAMA_URL', 'http://127.0.0.1:11434'));
        $model = 'nomic-embed-text'; // or nomic-embed-text, etc.

        foreach (Staff::all() as $staff) {
            $text = "{$staff->name}, {$staff->position} in {$staff->department}. Email: {$staff->email}";

            // Try /api/embed first, then fallback to /api/embeddings
            $resp = Http::timeout(60)->post($ollamaUrl . '/api/embed', [
                'model' => $model,
                'input' => $text,
            ]);

            if ($resp->failed()) {
                $resp = Http::post($ollamaUrl . '/api/embeddings', [
                    'model' => $model,
                    'prompt' => $text,
                ]);
            }

            $data = $resp->json();

            // Robust extraction of embedding from different possible shapes
            $embedding = null;
            if (isset($data['embedding'])) {
                $embedding = $data['embedding'];
            } elseif (isset($data['data'][0]['embedding'])) {
                $embedding = $data['data'][0]['embedding'];
            } elseif (isset($data['embeddings'][0])) {
                $embedding = $data['embeddings'][0];
            } elseif (isset($data['embeddings'])) {
                $embedding = $data['embeddings'];
            }

            if (!is_array($embedding)) {
                $this->error("Failed to get embedding for staff id {$staff->id}. Response: " . $resp->body());
                \Log::error("Embedding error for staff {$staff->id}: " . $resp->body());
                continue;
            }

            DB::table('staff_embeddings')->updateOrInsert(
                ['staff_id' => $staff->id],
                ['embedding' => json_encode($embedding), 'updated_at' => now(), 'created_at' => now()]
            );

            $this->info("Embedded: {$staff->name}");
        }

        $this->info("Done.");
    }
}