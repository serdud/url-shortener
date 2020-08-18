<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ShortenerService
{
    /**
     * @var Url
     */
    private $urlModel;

    /**
     * ShortenerService constructor.
     *
     * @param Url $urlModel
     */
    public function __construct(Url $urlModel)
    {
        $this->urlModel = $urlModel;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function shorten(string $url): string
    {
        $code = $this->getShortCode();
        $this->urlModel->create([
            'code' => $code,
            'url' => urldecode($url),
        ]);

        return route('shortened', ['shortcode' => $code]);
    }

    /**
     * @param string $shortCode
     *
     * @return string|null
     */
    public function getUrlByShortCode(string $shortCode): ?string
    {
        return Cache::remember($shortCode, config('shortening.cache_ttl'), function () use ($shortCode) {
            return optional($this->urlModel->getByCode($shortCode))->url;
        });
    }

    /**
     * @return string
     */
    private function getShortCode(): string
    {
        do {
            $shortCode = Str::random(config('shortening.code_length'));
            $unique = !$this->urlModel->getByCode($shortCode);
        } while (!$unique);

        return $shortCode;
    }
}
