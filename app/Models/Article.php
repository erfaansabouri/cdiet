<?php

namespace App\Models;

use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Article extends Model implements HasMedia {
    use InteractsWithMedia , Commentable;

    public function registerMediaCollections (): void {
        $this->addMediaCollection('image')
             ->singleFile();
    }

    public static function fixStyle ( $html ) {
        $modifiedHtml = preg_replace('/height="\d+"/' , '' , $html);
        // Replace the width attribute with "100%" using a regular expression
        $modifiedHtml = preg_replace('/width="\d+"/' , 'width="100%"' , $modifiedHtml);

        return $modifiedHtml;
    }
}
