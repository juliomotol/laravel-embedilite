<?php

namespace JulioMotol\Embedilite\Contracts;

interface Provider
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
