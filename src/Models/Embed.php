<?php

namespace JulioMotol\Embedilite\Models;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use JulioMotol\Embedilite\EmbediliteFacade as Embedilite;

class Embed extends Model implements Htmlable
{
    protected $casts = [
        'options' => 'array',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function toHtml()
    {
        return Embedilite::from($this->provider)
            ->setSource($this->source)
            ->toHtml();
    }
}
