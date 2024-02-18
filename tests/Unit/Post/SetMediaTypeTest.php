<?php

namespace Tests\Unit\Post;

use App\Models\Post;
use Tests\TestCase;

class SetMediaTypeTest extends TestCase
{
    /**
     * Tests if the model field 'type' gets set to YouTube
     * (https://www.youtube.com/watch?v=0jYQ58e1yXs)
     *
     * @test
     */
    public function set_media_type_sets_model_type_field_to_youtube_with_normal_youtube_url(): void
    {
        $originalYouTubeUrl = 'https://www.youtube.com/watch?v=0jYQ58e1yXs';

        $post = app(Post::class);

        $post->original_url = $originalYouTubeUrl;

        $post->setMediaType();

        $this->assertEquals('youtube', $post->type);
    }

    /**
     * Tests if the model field 'type' gets set to TikTok
     * (https://www.youtube.com/watch?v=0jYQ58e1yXs)
     *
     * @test
     */
    public function set_media_type_sets_model_type_field_to_tiktok_with_normal_tiktok_url(): void
    {
        $originalTikTokUrl = 'https://tiktok.com/@hex1ab/video/7251661199321107739';

        $post = app(Post::class);

        $post->original_url = $originalTikTokUrl;

        $post->setMediaType();

        $this->assertEquals('tiktok', $post->type);
    }

    /**
     * Tests if the model field 'type' gets set to null if base url is invalid
     * (https://www.youtube.com/watch?v=0jYQ58e1yXs)
     *
     * @test
     */
    public function set_media_type_sets_model_type_field_to_null_with_invalid_base_url(): void
    {
        $originalYouTubeUrl = 'https://www.google.com/maps';

        $post = app(Post::class);

        $post->original_url = $originalYouTubeUrl;

        $post->setMediaType();

        $this->assertEquals(null, $post->type);
    }
}
