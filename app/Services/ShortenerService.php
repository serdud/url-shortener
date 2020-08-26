<?php

namespace App\Services;

use App\Exceptions\UniqueCodeException;
use App\Models\Url;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Support\Str;

class ShortenerService
{
    /**
     * @var Url
     */
    private $urlModel;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * ShortenerService constructor.
     *
     * @param Url   $urlModel
     * @param Cache $cache
     */
    public function __construct(Url $urlModel, Cache $cache)
    {
        $this->urlModel = $urlModel;
        $this->cache = $cache;
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
        return $this->cache->remember($shortCode, config('shortening.cache_ttl'), function () use ($shortCode) {
            return optional($this->urlModel->getByCode($shortCode))->url;
        });
    }

    /**
     * @return string
     * @throws UniqueCodeException
     */
    private function getShortCode(): string
    {
        $attempt = 0;
        do {
            if ($attempt == config('shortening.generation_attempts')) {
                throw new UniqueCodeException('Attempts limit exceeded. Current limit: '  . config('shortening.generation_attempts'));
            }
            $shortCode = Str::random(config('shortening.code_length'));
            $unique = !$this->urlModel->getByCode($shortCode);
            ++$attempt;
        } while (!$unique);

        return $shortCode;
    }
}
