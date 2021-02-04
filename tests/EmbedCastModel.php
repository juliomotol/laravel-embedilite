<?php

namespace JulioMotol\Embedilite\Tests;

use Illuminate\Database\Eloquent\Model;
use JulioMotol\Embedilite\Casts\EmbedCast;
use JulioMotol\Embedilite\Traits\ConfiguresEmbed;

class EmbedCastModel extends Model
{
    use ConfiguresEmbed;

    protected $table = 'embed_cast_models';

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'embed' => EmbedCast::class . ':source,spotify',
    ];

    public function registerEmbedOptions(): void
    {
        $this->addEmbedOption('spotify');
    }
}
