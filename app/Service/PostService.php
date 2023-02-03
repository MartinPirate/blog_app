<?php

namespace App\Service;

use App\Models\Post;
use App\Models\User;
use App\Repositories\EndPointsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostService
{


    /**
     * fetch post
     * @return mixed
     */
    public static function fetch(): mixed
    {
        getAdmin();
        $postsURL = EndPointsRepository::getArticlesUrl();

        try {
            $data = Http::get($postsURL);

        } catch (Throwable $exception) {
            Log::error($exception->getMessage());

        }
        return $data['articles'];
    }

    public static function saveImports(): Application|Translator|string|array|null
    {

        $userId = getAdmin();
        $posts = PostService::fetch();

        DB::beginTransaction();
        try {
            foreach ($posts as $post) {
                $new_post = new Post();
                $new_post->user_id = $userId;
                $new_post->title = $post['title'];
                $new_post->description = $post['description'];
                $new_post->publishedAt = $post['publishedAt'];
                $new_post->save();
            }
            DB::commit();
            Cache::forget('posts');

        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
            DB::rollback();
        }
        return trans('messages.success_import');

    }

}
