<?php

namespace JulioMotol\Embedilite;

use Illuminate\Support\Manager;
use InvalidArgumentException;
use JulioMotol\Embedilite\Contracts\Factory;
use JulioMotol\Embedilite\Contracts\Provider;
use JulioMotol\Embedilite\Providers\SpotifyProvider;
use JulioMotol\Embedilite\Providers\YoutubeProvider;

class EmbediliteManager extends Manager implements Factory
{
    /**
     * Get the embed provider instance.
     *
     * @param string $provider
     * @return Provider
     */
    public function from(string $provider): Provider
    {
        return $this->driver($provider);
    }

    /**
     * Create an instance of a Spotify embed driver.
     *
     * @return SpotifyProvider
     */
    protected function createSpotifyDriver()
    {
        return new SpotifyProvider;
    }

    /**
     * Create an instance of a Youtube embed driver.
     *
     * @return YoutubeProvider
     */
    protected function createYoutubeDriver()
    {
        return new YoutubeProvider;
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
