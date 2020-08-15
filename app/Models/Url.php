<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'code',
        'url',
    ];

    /**
     * @param string $code
     *
     * @return Url|null
     */
    public function getByCode(string $code): ?Url
    {
        return $this->where('code', $code)->first();
    }
}
