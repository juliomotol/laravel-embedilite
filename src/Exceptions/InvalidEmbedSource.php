<?php

namespace JulioMotol\Embedilite\Exceptions;

use Exception;
use JulioMotol\Embedilite\Providers\Provider;
use Illuminate\Support\Str;

class InvalidEmbedSource extends Exception
{
    /**
     * The embed provider.
     * 
     * @var Provider
     */
    protected Provider $provider;

    /**
     * Create a new exception instance.
     *
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;

        $name = Str::lower($this->provider->name());

        parent::__construct("Invalid $name embed source.");
    }
}
