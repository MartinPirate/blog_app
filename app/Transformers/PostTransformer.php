<?php

namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract

{
    /**
     * A Fractal transformer.
     *
     * @param Post $post
     * @return array
     */
    public function transform(Post $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'date' => getMonthAndDate($post->publishedAt),
            'time' => getTime($post->publishedAt),
        ];
    }

}

