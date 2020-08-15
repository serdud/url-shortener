<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenRequest;
use App\Services\ShortenerService;

class UrlController extends Controller
{
    /**
     * @var ShortenerService
     */
    private $shortenerService;

    /**
     * UrlController constructor.
     *
     * @param ShortenerService $shortenerService
     */
    public function __construct(ShortenerService $shortenerService)
    {
        $this->shortenerService = $shortenerService;
    }

    /**
     * @param ShortenRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function shorten(ShortenRequest $request)
    {
        return response()->json(['url' => $this->shortenerService->shorten($request->url)]);
    }

    /**
     * @param $shortcode
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect($shortcode)
    {
        $url = $this->shortenerService->getUrlByShortCode($shortcode);

        return $url ? redirect($url) : abort(404);
    }
}
