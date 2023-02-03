<?php

use App\Models\User;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;

/**
 *
 * /*if (!function_exists('importPosts')) {
 *
 * function importPosts(): void
 * {
 *
 * //todo move this to the .env or config file
 * $admin = User::whereRoleIs('admin')->first();
 * if (!$admin) {
 * abort(403, 'Unauthorized action.');
 * }
 * DB::beginTransaction();
 * try {
 * $data = Http::get('https://candidate-test.sq1.io/api.php');    //todo move this to the .env or config file
 *
 * $posts = $data->json()['articles'];
 *
 * foreach ($posts as $post) {
 * $new_post = new Post();
 * $new_post->user_id = $admin->id;
 * $new_post->title = $post['title'];
 * $new_post->description = $post['description'];
 * $new_post->publishedAt = $post['publishedAt'];
 * $new_post->save();
 * }
 * DB::commit();
 * Cache::forget('posts');
 *
 * } catch (Throwable $exception) {
 * Log::error($exception->getMessage());
 * DB::rollback();
 * }
 *
 *
 * }
 *
 * }*/

/**
 * Get Admin
 * @return HigherOrderBuilderProxy|int|mixed
 */

if (!function_exists('getAdmin')) {

    function getAdmin(): mixed
    {
        $admin = User::whereRoleIs('admin')->first();
        if (!$admin) {
            abort(404, 'Unauthorized Import, No admin user Found,  please seed the database to create an admin user.');
        }
        return $admin->id;
    }
}

