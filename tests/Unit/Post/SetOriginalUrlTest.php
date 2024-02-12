<?php

namespace Tests\Unit\Post;

use App\Models\Post;
use Tests\TestCase;

class SetOriginalUrlTest extends TestCase
{
    private string $expectedNormalYoutubeUrl = 'https://www.youtube.com/watch?v=0jYQ58e1yXs';
    private string $expectedShortsYoutubeUrl = 'https://www.youtube.com/shorts/D4u-BW_YgPA';
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

    /**
     * Tests if a shorts YouTube video url gets parsed correctly
     * (https://www.youtube.com/shorts/D4u-BW_YgPA)
     *
     * @test
     */
    public function set_original_url_sets_correct_url_with_shorts_youtube_video_url(): void
    {
        $originalYouTubeUrl = 'https://www.youtube.com/shorts/D4u-BW_YgPA';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrl);

        $this->assertEquals($this->expectedShortsYoutubeUrl, $post->original_url);
    }

    /**
     * Tests if a shorts YouTube video url generated from a share button gets parsed correctly
     * (https://youtube.com/shorts/D4u-BW_YgPA?si=YQtfO_-Gd5iE9doW)
     *
     * @test
     */
    public function set_original_url_sets_correct_url_with_shorts_share_youtube_video_url()
    {
        $originalShareYouTubeUrl = 'https://youtube.com/shorts/D4u-BW_YgPA?si=YQtfO_-Gd5iE9doW';

        $post = app(Post::class);

        $post->setOriginalUrl($originalShareYouTubeUrl);

        $this->assertEquals($this->expectedShortsYoutubeUrl, $post->original_url);
    }

    /**
     * The set original url method should discard all unnecessary url query parameters.
     * Since YouTube shorts videos do not support timestamps. All url query params should be discarded
     * (https://www.youtube.com/shorts/D4u-BW_YgPA?t=101s&si=test&foo=bar)
     *
     * @test
     */
    public function set_original_url_removes_all_unnecessary_url_query_parameters_from_shorts_youtube_url()
    {
        $originalYouTubeUrlWithTimestamp = 'https://www.youtube.com/shorts/D4u-BW_YgPA?t=101s&si=test&foo=bar';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrlWithTimestamp);

        $this->assertEquals($this->expectedShortsYoutubeUrl, $post->original_url);
    }

    /**
     * The set original url method should discard all unnecessary url query parameters.
     * Since YouTube shorts videos do not support timestamps. All url query params should be discarded
     * (https://youtube.com/shorts/D4u-BW_YgPA?si=YwnKxGj4FR7vIKNo&t=101s&foo=bar)
     *
     * @test
     */
    public function set_original_url_removes_all_unnecessary_url_query_parameters_from_shared_shorts_youtube_url()
    {
        $originalYouTubeUrlWithTimestamp = 'https://youtube.com/shorts/D4u-BW_YgPA?si=YwnKxGj4FR7vIKNo&t=101s&foo=bar';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrlWithTimestamp);

        $this->assertEquals($this->expectedShortsYoutubeUrl, $post->original_url);
    }

    /**
     * Tests if a YouTube URL starting without a "www." gets "www."
     * (https://youtube.com/shorts/D4u-BW_YgPA)
     *
     * @test
     */
    public function set_original_url_adds_www_prefix_to_url(): void
    {
        $originalYouTubeUrl = 'https://youtube.com/shorts/D4u-BW_YgPA';

        $post = app(Post::class);

        $post->setOriginalUrl($originalYouTubeUrl);

        $this->assertTrue(str_starts_with($post->original_url, 'https://www.'));
    }
}
