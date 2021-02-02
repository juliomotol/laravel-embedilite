<?php

namespace JulioMotol\Embedilite\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SpotifyProvider extends Provider
{
    protected const URL_PREFIX = 'https://open.spotify.com/';
    protected const URI_PREFIX = 'spotify:';

    /**
     * The embed view template.
     *
     * @var string
     */
    protected $view = 'embedilite::spotify';

    /**
     * Validate the given embed source.
     * 
     * @param string $source
     * @return bool
     */
    public static function validateSource(string $source): bool
    {
        return Str::startsWith($source, [self::URL_PREFIX, self::URI_PREFIX]);
    }

    /**
     * Parse the source to the data needed to render the embed.
     * 
     * @return array
     */
    public function parseSource(): array
    {
        if (Str::startsWith($this->source, self::URL_PREFIX)) {
            return $this->parseUrl($this->source);
        }

        if (Str::startsWith($this->source, self::URI_PREFIX)) {
            return $this->parseUri($this->source);
        }

        throw new \Exception();
    }

    /**
     * Parse the Spotify url
     *
     * @param string $url
     * @return array
     */
    protected function parseUrl(string $url): array
    {
        $urlStructure = parse_url($url);

        $parts = Collection::make(explode('/', $urlStructure['path']))
            ->filter()
            ->values();

        return [
            'id' => $parts->pop(),
            'type' => $parts->pop()
        ];
    }

    /**
     * Parse the Spotify uri
     *
     * @param string $uri
     * @return array
     */
    protected function parseUri(string $uri): array
    {
        $parts = Str::of($uri)
            ->explode(':');

        return [
            'id' => $parts->pop(),
            'type' => $parts->pop()
        ];
    }
}
