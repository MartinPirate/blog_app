<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFilterRequest;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class PostsController extends Controller
{
    public function welcome(PostFilterRequest $request): Response
    {
        $posts = Post::with('user')
            ->filter($request->only('sortBy', 'direction'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'author' => $post->user->name,
                'published_date' => $post->publishedAt->format('d M Y'),
            ]);

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'filters' => $request->only('sortBy', 'direction'),
            'posts' => $posts]);
    }

    public function index(PostFilterRequest $request): Response
    {

        $userId = auth()->user()->id;

        $posts = Post::orderBy('created_at', 'DESC')
            ->with('user')
            ->filter($request->only('sortBy', 'direction'))
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
                'posts' => $posts,
                'filters' => $request->only('sortBy', 'direction'),
            ]);

    }

    public function create(): Response
    {
        return Inertia::render('Post/Create');
    }

    /**
     * add a new Post
     * @param PostRequest $request
     * @return Redirector|Application|RedirectResponse
     */
    public function store(PostRequest $request): Redirector|Application|RedirectResponse
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

    }


}
