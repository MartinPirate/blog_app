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
            'author' => $post->user->name,
            'published_date' => $post->publishedAt->format('d M Y'),
        ];
    }

}

