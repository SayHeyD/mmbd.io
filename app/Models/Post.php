<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nette\NotImplementedException;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id', 'name', 'type', 'slug', 'original_url',
    ];

    /**
     * Set the 'type' field of the Post model based on the original URL
     *
     * @return void
     */
    public function setMediaType(): void
    {
        $this->type = $this->selectMediaType($this->original_url);
    }

    public function setOriginalUrl(string $url): void
    {
        switch ($this->selectMediaType($url)) {
            case 'youtube':
                $this->original_url = $this->getYoutubeUrl($url);
                break;
            case 'tiktok':
                throw new NotImplementedException();
        }
    }

    public static function selectMediaType(string $url): string|null
    {
        $platforms = config('supported_platforms.platforms', []);

        foreach ($platforms as $key => $platform) {
            foreach ($platform['urls'] as $baseUrl) {
                if (str_starts_with($url, $baseUrl)) {
                    return $key;
                }
            }
        }

        return null;
    }

    public static function getYoutubeUrl(string $url): string|null
    {
        $parsedUrl = parse_url($url);
        $urlQueries = $parsedUrl['query'];
        $queryParameters = explode('&', $urlQueries);

        $videoId = '';
        $timestamp = '';

        if ($parsedUrl['host'] == 'youtu.be') {
            $videoId = Post::getVideoIdFromYoutubeShareUrl($url);
        }

        foreach ($queryParameters as $param) {
            $key = explode('=', $param)[0];
            $value = explode('=', $param)[1];

            if ($key == 'v') {
                $videoId = $value;
                continue;
            }

            if ($key == 't') {

                $timestamp = $value;
            }
        }

        $finishedUrl = 'https://www.youtube.com/watch?v=' . $videoId;

        if ($timestamp !== '') {
            $finishedUrl .= '&t=' . $timestamp;
        }

        return $finishedUrl;
    }

    private static function getVideoIdFromYoutubeShareUrl(string $url): string
    {
        $parsedUrl = parse_url($url);

        return str_replace('/', '', $parsedUrl['path']);
    }

    private static function getTimestampFromYoutubeUrl(string $url): string
    {

    }
}
