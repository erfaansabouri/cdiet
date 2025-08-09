<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource {
    public function toArray ( Request $request ): array {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'body' => Article::fixStyle($this->body) ,
            'image_url' => $this->getFirstMediaUrl('image') ,
        ];
    }
}
