<?php

namespace App\Rules;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class UrlIsSupportedPlatform implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $supportedPlatforms = config('supported_platforms.platforms', []);

        foreach ($supportedPlatforms as $platform) {
            foreach ($platform['urls'] as $baseUrl) {
                if (str_starts_with($value, $baseUrl)) {

                    switch (Post::selectMediaType($value)) {
                        case 'youtube':
                            if (! $this->validYouTubeUrl($value)) {
                                // Break out of switch and 2 foreach loops
                                break 3;
                            }

                            return;
                        case 'tiktok':
                            if (! $this->validTikTokUrl($value)) {
                                // Break out of switch and 2 foreach loops
                                break 3;
                            }

                            return;
                    }
                }
            }
        }

        $fail('The :attribute must be a supported and valid URL');
    }

    private function validYouTubeUrl(string $url): bool
    {
        $youtubeUrl = Post::getYoutubeUrl($url);
        $response = Http::head($youtubeUrl);

        if ($response->status() != 200) {
            return false;
        }

        return true;
    }

    private function validTikTokUrl(string $url): bool
    {
        return true;
    }
}
