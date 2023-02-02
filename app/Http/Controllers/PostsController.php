<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class PostsController extends Controller
{
    public function welcome(): Response
    {

        $posts = $this->getPosts();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'posts' => $posts]);
    }

    public function index(): Response
    {
        return Inertia::render('Dashboard');

    }

    /**
     * Get Posts
     * @return mixed
     */
    private function getPosts()
    {
        return Post::orderBy('created_at', 'DESC')
            ->with('user')
            ->filter()
            ->paginate(10)
            ->withQueryString()
            ->through(fn($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'author' => $post->user->name,
                'published_date' => $post->publishedAt->format('d M Y'),
            ]);

    }
}
