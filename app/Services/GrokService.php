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
            'role' => 'system' ,
            'content' => 'You are a helpful assistant for a diet application, introduce your self as calorie-diet ai and do not suggest any application about diet. just answer questions about diet or exercises or calorie or fat or carbohydrate and health subjects, if user asked any other question tell me he or she is not allowed to ask' ,
        ];
        $messages[] = [
            'role' => 'user' ,
            'content' => $message ,
        ];

        return Http::timeout(60)->withHeaders([
                                     'Authorization' => $this->api_token ,
                                 ])
                   ->post('https://api.x.ai/v1/chat/completions' , [
                       'model' => 'grok-3-latest' ,
                       'stream' => false ,
                       'temperature' => 0.7 ,
                       'messages' => $messages ,
                       'max_completion_tokens' => 500,
                   ])
                   ->json()[ 'choices' ][ 0 ][ 'message' ][ 'content' ];
    }
}
