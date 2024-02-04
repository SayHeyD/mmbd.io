<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function success()
    {
        if (session()->has('flash.slug') == null) {
            return redirect()->route('index');
        }

        return Inertia::render('Post/Success', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = new Post();

        if (Auth::check()) {
            $post->team_id = Auth::user()->currentTeam->id;
        }

        $post->expires_at = Carbon::now()->addDays(7)->toDateTime();

        $post->setOriginalUrl($request->link);
        $post->setMediaType();

        $slugFound = true;
        $length = random_int(4, 12);
        $slug = bin2hex(openssl_random_pseudo_bytes($length));
        while ($slugFound) {
            $slugFound = Post::where('slug', $slug)->first() != null;
        }

        $post->slug = $slug;

        $post->save();

        session()->flash('flash.slug', $post->slug);

        if (Auth::check()) {
            return redirect()->route('post.dashboard');
        } else {
            return redirect()->route('post.success');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return Inertia::render('Post/Show', [
            'post' => $post,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
