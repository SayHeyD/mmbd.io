<?php

namespace Tests\Unit\Post;

use App\Models\Post;
use Tests\TestCase;

class SetOriginalUrlTest extends TestCase
{
    private string $expectedNormalYoutubeUrl = 'https://www.youtube.com/watch?v=0jYQ58e1yXs';
    private string $expectedNormalYoutubeUrlWithTimestamp = 'https://www.youtube.com/watch?v=0jYQ58e1yXs&t=101';

    /**
     * Tests if a normal YouTube video url gets parsed correctly
     * (https://www.youtube.com/watch?v=0jYQ58e1yXs)
     *
     * @test
     */
    public function set_original_url_sets_correct_url_with_normal_youtube_video_url(): void
    {
        $originalYouTubeUrl = 'https://www.youtube.com/watch?v=0jYQ58e1yXs';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrl);

        $this->assertEquals($this->expectedNormalYoutubeUrl, $post->original_url);
    }

    /**
     * Tests if a YouTube video url generated from a share button gets parsed correctly
     * (https://youtu.be/0jYQ58e1yXs?si=webTBvCxRVKMMjav)
     *
     * @test
     */
    public function set_original_url_sets_correct_url_with_share_youtube_video_url()
    {
        $originalShareYouTubeUrl = 'https://youtu.be/0jYQ58e1yXs?si=Zg95ZsU5pXnVcQeO';

        $post = app(Post::class);

        $post->setOriginalUrl($originalShareYouTubeUrl);

        $this->assertEquals($this->expectedNormalYoutubeUrl, $post->original_url);
    }

    /**
     * Tests if a YouTube video url generated from a share button, with a timestamp gets parsed correctly
     * (https://www.youtube.com/watch?v=0jYQ58e1yXs&t=101s)
     *
     * @test
     */
    public function set_original_url_sets_correct_url_with_normal_youtube_video_url_and_timestamp()
    {
        $originalYouTubeUrlWithTimestamp = 'https://www.youtube.com/watch?v=0jYQ58e1yXs&t=101s';
        $expectedUrl = $this->expectedNormalYoutubeUrlWithTimestamp . 's';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrlWithTimestamp);

        $this->assertEquals($expectedUrl, $post->original_url);
    }

    /**
     * Tests if a YouTube video url generated from a share button, with a timestamp gets parsed correctly
     * (https://youtu.be/0jYQ58e1yXs?si=0n82N8gZRRCoQ-bW&t=101)
     *
     * @test
     */
    public function set_original_url_sets_correct_url_with_share_youtube_video_url_and_timestamp()
    {
        $originalYouTubeUrlWithTimestamp = 'https://youtu.be/0jYQ58e1yXs?si=Zg95ZsU5pXnVcQeO&t=101';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrlWithTimestamp);

        $this->assertEquals($this->expectedNormalYoutubeUrlWithTimestamp, $post->original_url);
    }

    /**
     * The set original url method should discard all unnecessary url query parameters.
     * IN essence only the 'v' and the 't' query parameters should make it through.
     * (https://www.youtube.com/watch?v=0jYQ58e1yXs&t=101s&si=test&foo=bar)
     *
     * @test
     */
    public function set_original_url_removes_all_unnecessary_url_query_parameters_from_normal_youtube_url()
    {
        $originalYouTubeUrlWithTimestamp = 'https://www.youtube.com/watch?v=0jYQ58e1yXs&t=101s&si=test&foo=bar';
        $expectedUrl = $this->expectedNormalYoutubeUrlWithTimestamp . 's';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrlWithTimestamp);

        $this->assertEquals($expectedUrl, $post->original_url);
    }

    /**
     * The set original url method should discard all unnecessary url query parameters.
     * IN essence only the 'v' and the 't' query parameters should make it through.
     * (https://youtu.be/0jYQ58e1yXs?si=hmAnUiaCY2RrqLje&t=101&test=no&foo=bar)
     *
     * @test
     */
    public function set_original_url_removes_all_unnecessary_url_query_parameters_from_share_youtube_url()
    {
        $originalYouTubeUrlWithTimestamp = 'https://youtu.be/0jYQ58e1yXs?si=hmAnUiaCY2RrqLje&t=101&test=no&foo=bar';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrlWithTimestamp);

        $this->assertEquals($this->expectedNormalYoutubeUrlWithTimestamp, $post->original_url);
    }
}
