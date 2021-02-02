<?php

namespace JulioMotol\Embedilite\Contracts;

interface Factory
{
    /**
     * Get the embed provider instance.
     *
     * @param string $provider
     * @return Provider
     */
    public function from(string $provider): Provider;
}
