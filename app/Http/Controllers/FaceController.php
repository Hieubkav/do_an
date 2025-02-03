<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use OpenAI;

class FaceController extends Controller
{
    public function index()
    {
        return view('main.face');
    }
    function ask_form(){
        return view('main.ask');                                                                
    }

    public function ask(Request $input)
    {
        if ($input->title == null) {
            return;
        }
    
        $title = $input->title;
        
        $client = OpenAI::client(env('OPENAI_API_KEY'));
    
        $result = $client->completions()->create([
            "model" => "text-davinci-003",
            "temperature" => 0.7,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            'max_tokens' => 600,
            'prompt' => sprintf('Write article about: %s', $title),
        ]);
    
        $content = trim($result['choices'][0]['text']);

        return view('main.ask', compact('title', 'content'));
    }
}
