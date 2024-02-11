<?php

namespace App\Actions\Post;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreatePost
{
    /**
     * Store a post according to the URL type
     *
     * @param StorePostRequest $request
     * @return void
     * @throws \Random\RandomException
     */
    public function Store(StorePostRequest $request): void
    {
        $post = new Post();

        if (Auth::check()) {
            $post->team_id = Auth::user()->currentTeam->id;
            $post->name = $request->name;
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
    }
}
