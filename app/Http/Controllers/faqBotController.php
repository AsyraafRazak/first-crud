<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudstudio\OllamaLaravel\Facades\Ollama;
use App\Models\Staff;

class faqBotController extends Controller
{
    public function index()
    {
        return view('faqBot.index'); // load the Blade view
    }

    public function chat(Request $request)
    {
        $message = strtolower($request->input('message'));

        // Example: Search staff by name
        $staff = Staff::where('name', 'like', '%' . $message . '%')->first();

        if ($staff) {
            $reply = "I found {$staff->name}, working as {$staff->position} in {$staff->department}. 
                     You can contact them at {$staff->email}, phone: {$staff->phone}.";
        } else {
            $reply = "Sorry, I couldn't find staff info related to: {$request->input('message')}";
        }

        return response()->json([
            'user' => $request->input('message'),
            'bot' => $reply,
        ]);
    }
}
