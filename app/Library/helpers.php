<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 *
 * Import Posts command function
 * @return void
 */

if (!function_exists('importPosts')) {

    function importPosts(): string
    {

        //todo move this to the .env or config file
        $admin = User::whereRoleIs('admin')->first();
        if (!$admin) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $data = Http::get('https://candidate-test.sq1.io/api.php');    //todo move this to the .env or config file

            $posts = $data->json()['articles'];

            foreach ($posts as $post) {
                $new_post = new Post();
                $new_post->user_id = $admin->id;
                $new_post->title = $post['title'];
                $new_post->description = $post['description'];
                $new_post->publishedAt = $post['publishedAt'];
                $new_post->save();
            }
            Cache::tags('posts')->flush();

        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
        }


    }

}

/**
 * Format Date to month Name and Date
 * @param $date
 * @return mixed|string
 */

if (!function_exists('getMonthAndDate')) {

    function getMonthAndDate($date)
    {
        try {
            return $date->format('F d');
        } catch (Throwable $exception) {
            return $exception->getMessage();
        }

    }
}

