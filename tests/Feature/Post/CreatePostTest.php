<?php

namespace Tests\Feature\Post;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if a request to store a post redirects to the 'post.success' page
     *
     * @test
     */
    public function create_post_with_youtube_url_redirects_to_success_page(): void
    {
        $response = $this->put(route('post.store'), [
            'link' => 'https://www.youtube.com/watch?v=0jYQ58e1yXs'
        ]);

        $response->assertRedirect(route('post.success'));
    }

    /**
     * Tests if a request to store a post sets the 'flash.slug' session flash message
     *
     * @test
     */
    public function create_post_with_youtube_url_redirects_with_flash_message(): void
    {
        $this->put(route('post.store'), [
            'link' => 'https://www.youtube.com/watch?v=0jYQ58e1yXs'
        ]);

        dump();

        $this->assertTrue(session()->has('flash.slug'));
    }

    /**
     * Tests if a request to store a post route stores the post with the correct data
     * Since there is no user session, the name of the post cannot be set and the team_id must also be null
     *
     * @test
     */
    public function create_post_stores_post_in_database_without_user_session(): void
    {
        $youtubeUrl = 'https://www.youtube.com/watch?v=0jYQ58e1yXs';

        $this->put(route('post.store'), [
            'link' => $youtubeUrl
        ]);

        $slug = session()->get('flash.slug');

        $this->assertDatabaseHas('posts', [
            'original_url' => $youtubeUrl,
            'slug' => $slug,
            'type' => 'youtube',
            'team_id' => null,
            'name' => null
        ]);
    }

    /**
     * Tests if a request to store a post route stores the post with the correct data
     * Since there is no user session, the name of the post cannot be set and the team_id must also be null
     *
     * @test
     */
    public function create_post_stores_post_in_database_with_user_session(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $youtubeUrl = 'https://www.youtube.com/watch?v=0jYQ58e1yXs';
        $postName = 'test';

        $this->put(route('post.store'), [
            'name' => $postName,
            'link' => $youtubeUrl
        ]);

        $slug = session()->get('flash.slug');

        $this->assertDatabaseHas('posts', [
            'original_url' => $youtubeUrl,
            'slug' => $slug,
            'type' => 'youtube',
            'team_id' => $user->currentTeam->id,
            'name' => $postName
        ]);
    }

    /**
     * Tests if a request to store a post route stores the post with the correct data
     * Since there is no user session, the name of the post cannot be set and the team_id must also be null
     *
     * @test
     */
    public function create_post_returns_error_if_unauthenticated_user_tries_to_set_post_name(): void
    {
        $youtubeUrl = 'https://www.youtube.com/watch?v=0jYQ58e1yXs';
        $postName = 'test';

        $this->put(route('post.store'), [
            'name' => $postName,
            'link' => $youtubeUrl
        ]);

        $this->assertDatabaseMissing('posts', [
            'name' => $youtubeUrl,
            'original_url' => $postName
        ]);
    }

    /**
     * Tests if a request to store a post route stores the post with the correct data
     * Since there is no user session, the name of the post cannot be set and the team_id must also be null
     *
     * @test
     */
    public function create_post_does_not_store_if_unauthenticated_user_tries_to_set_post_name(): void
    {
        $youtubeUrl = 'https://www.youtube.com/watch?v=0jYQ58e1yXs';
        $postName = 'test';

        $response = $this->put(route('post.store'), [
            'name' => $postName,
            'link' => $youtubeUrl
        ]);

        $response->assertSessionHasErrors('name');
    }
}
