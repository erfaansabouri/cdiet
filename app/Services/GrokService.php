<?php

namespace App\Services;

use App\Models\Message;
use Http;

class GrokService {
    public string $api_token;

    public function __construct () { $this->api_token = env('GROK_API'); }

    public function sendMessage ( $user_id , $message ) {
        $messages = Message::query()
                           ->where('user_id' , $user_id)
                           ->orderBy('id')
                           ->take(30)
                           ->get([
                                     'role' ,
                                     'content' ,
                                 ])
                           ->toArray();
        $messages[] = [
            'role' => 'user' ,
            'content' => $message ,
        ];

        return Http::withHeaders([
                                     'Authorization' => $this->api_token ,
                                 ])
                   ->post('https://api.x.ai/v1/chat/completions' , [
                       'model' => 'grok-3-latest' ,
                       'stream' => false ,
                       'temperature' => 0.7 ,
                       'messages' => $messages ,
                   ])
                   ->json()[ 'choices' ][ 0 ][ 'message' ][ 'content' ];
    }
}
