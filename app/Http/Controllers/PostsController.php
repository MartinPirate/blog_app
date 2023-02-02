<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
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
            'posts' => $posts]);
    }

    public function index(): Response
    {

        $userId = auth()->user()->id;

        $posts = Post::orderBy('created_at', 'DESC')
            ->with('user')
            ->where('user_id', '=', $userId)
            ->paginate(10)
            ->withQueryString()
            ->through(fn($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'author' => $post->user->name,
                'published_date' => $post->publishedAt->format('d M Y'),
            ]);

        return Inertia::render('Dashboard',
            [
                'posts' => $posts
            ]);

    }

    public function create(): Response
    {
        return Inertia::render('Post/Create');
    }

    public function store(PostRequest $request)
    {
        $user = $request->user();
        if (!$user) {
            abort(403, "no authenticated User Found");
        }
        //find if post exist by combining datetime and title

        //save the post

        $post = new Post();

        $post->title = $request->title;
        $post->description = $request->description;
        $post->publishedAt = $request->publishedAt;
        $post->user_id = $user->id;
        $post->save();

        return redirect('dashboard')->with('success', 'post added successfully');

        //
    }

    /**
     * Get Posts
     * @param int|null $userId
     * @return mixed
     */
    private function getPosts(): mixed
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
