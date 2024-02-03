<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UrlIsSupportedPlatform implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $supportedBaseUrls = config('supported_platforms.base_urls', []);

        $foundMatch = false;

        foreach ($supportedBaseUrls as $baseUrl) {
            if (str_starts_with($value, $baseUrl)) {
                $foundMatch = true;
                break;
            }
        }

        if (!$foundMatch) {
            $fail('The :attribute must be a supported base URL');
        }
    }
}