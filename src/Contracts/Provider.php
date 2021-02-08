<?php

namespace JulioMotol\Embedilite\Contracts;

use Illuminate\Contracts\Support\Htmlable;

interface Provider extends Htmlable
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
     * @return string
     */
    public function parseSource(): string;

    /**
     * Set the embed source.
     *
     * @param string $source
     * @return self
     */
    public function setSource(string $source): self;

    /**
     * Set the embed options.
     *
     * @param array $options
     * @return self
     */
    public function setOptions(array $options): self;
}
