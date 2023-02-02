<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class PostsController extends Controller
{
    public function welcome(): Response
    {

        $posts = $this->getPostsJson();
        return Inertia::render('Welcome', [
            'posts' => $posts]);
    }

    public function index(): Response
    {
        return Inertia::render('Dashboard');

    }

    private function getPostsJson()
    {
        $posts = Post::all();

        return $posts;

    }
}
