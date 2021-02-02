<?php

namespace JulioMotol\Embedilite;

use Illuminate\Support\Manager;
use InvalidArgumentException;
use JulioMotol\Embedilite\Providers\SpotifyProvider;

class EmbediliteManager extends Manager
{
    /**
     * Get the embed provideri instance.
     *
     * @param string $driver
     * @return \JulioMotol\Embedilite\Providers\Provider
     */
    public function from(string $driver)
    {
        return $this->driver($driver);
    }

    /**
     * Get the default driver name.
     *
     * @throws InvalidArgumentException
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No Embedilite driver was specified.');
    }
}
