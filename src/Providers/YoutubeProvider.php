<?php

namespace JulioMotol\Embedilite\Providers;

use Illuminate\Support\Str;

class YoutubeProvider extends Provider
{
    protected const EMBED_URL_PREFIX = 'https://www.youtube.com/embed/';
    protected const VIDEO_URL_PREFIX = 'https://www.youtube.com/watch?';

    /**
     * The embed view template.
     *
     * @var string
     */
    protected string $view = 'embedilite::youtube';

    /**
     * Validate the given embed source.
     *
     * @param string $source
     * @return bool
     */
    public static function validateSource(string $source): bool
    {
        return Str::startsWith($source, [self::EMBED_URL_PREFIX, self::VIDEO_URL_PREFIX]);
    }

    /**
     * Parse the source to the data needed to render the embed.
     *
     * @return string
     */
    public function parseSource(): string
    {
        $queryString = http_build_query(array_merge(['origin' => url('/')], $this->options));

        return self::EMBED_URL_PREFIX . $this->parseVideoId($this->source) . ($queryString ? '?' . $queryString : '');
    }

    /**
     * Parse the Spotify url
     *
     * @param string $url
     * @return array
     */
    protected function parseVideoId(string $url): string
    {
        ['path' => $path, 'query' => $query] = parse_url($url);

        $path = array_values(array_filter(explode('/', $path)));
        parse_str($query, $query);

        return ($embedPath = array_search('embed', $path))
            ? $path[$embedPath + 1]
            : $query['v'];
    }
}
