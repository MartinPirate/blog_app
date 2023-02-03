<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFilterRequest;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Transformers\PostTransformer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use TheSeer\Tokenizer\Exception;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => [
            'welcome', 'show',
        ]]);
    }


    /**
     * Get Posts for the welcome page
     * @param PostFilterRequest $request
     * @return Response
     */
    public function welcome(PostFilterRequest $request): Response
    {
        $filterInputsHash = md5(serialize($request->only('sortBy', 'direction')));

        $posts = cache()->tags('posts')->remember($filterInputsHash, 60 * 60, function () use ($request) {
            return Post::with('user')
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
        });


        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'filters' => $request->only('sortBy', 'direction'),
            'posts' => $posts]);
    }

    /**
     * Get Posts for the admin page
     * @param PostFilterRequest $request
     * @return Response
     */
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

    /**
     * Create a post page
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Post/Create');
    }

    /**
     *Show post Details
     * @param Post $post
     * @return Response
     */
    public function show(Post $post): Response
    {
        $post = [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'author' => $post->user->name,
            'published_date' => $post->publishedAt->format('d M Y'),
        ];

        return Inertia::render('Post/Show', [
            'post' => $post
        ]);

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
        //todo find if post exist by combining datetime and title

        DB::beginTransaction();

        try {
            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->publishedAt = $request->publishedAt;
            $post->user_id = $user->id;
            $post->save();

            DB::commit();

            Cache::forget('posts');
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            DB::rollback();

            return redirect()->back()->withInput()->with('error', trans('message.failed'));
        }


        return redirect('dashboard')->with('success', trans('messages.success_store'));
    }


}
