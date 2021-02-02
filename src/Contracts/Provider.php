<?php

namespace JulioMotol\Embedilite\Contracts;

use Illuminate\Contracts\Support\Renderable;

interface Provider extends Renderable
{
    /**
     * Validate the given embed source.
     *
     * @param string $source
     * @return bool
     */
    public static function validateSource(string $source): bool;

    /**
     * Parse the source to the data needed to render the embed.
     *
     * @return array
     */
    public function parseSource(): array;
}
