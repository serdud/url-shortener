<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;

class ShortenRequest extends Request
{
    public function prepareForValidation()
    {
        $url = $this->input('url');

        if (!Str::startsWith($url, ['https://', 'http://'])) {
            $this->merge(['url' => "https://{$url}"]);
        }
    }

    public function rules()
    {
        return [
            'url' => 'required|url|max:2000',
        ];
    }
}
