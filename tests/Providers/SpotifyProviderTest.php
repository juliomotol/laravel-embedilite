<?php

namespace JulioMotol\Embedilite\Tests\Providers;

use Illuminate\Support\Facades\View;
use JulioMotol\Embedilite\Contracts\Factory;
use JulioMotol\Embedilite\EmbediliteFacade as Embedilite;
use JulioMotol\Embedilite\Exceptions\InvalidEmbedSource;
use JulioMotol\Embedilite\Tests\TestCase;

class SpotifyProviderTest extends TestCase
{
    protected const SPOTIFY_ID = '4uLU6hMCjMI75M1A2tKUQC';
    protected const SPOTIFY_TYPE = 'track';
    protected const SPOTIFY_URL = "https://open.spotify.com/track/4uLU6hMCjMI75M1A2tKUQC?si=luAVdOJiSEiQZKyATwWuDA";
    protected const SPOTIFY_URI = 'spotify:track:4uLU6hMCjMI75M1A2tKUQC';

    protected Factory $embedilite;

    /** @test */
    public function it_validates_spotify_url()
    {
        $this->assertTrue(Embedilite::from('spotify')->validateSource(self::SPOTIFY_URL));
    }

    /** @test */
    public function it_validates_spotify_uri()
    {
        $this->assertTrue(Embedilite::from('spotify')->validateSource(self::SPOTIFY_URI));
    }

    /** @test */
    public function it_validates_invalid_spotify_source()
    {
        $this->assertFalse(Embedilite::from('spotify')->validateSource(''));
    }

    /** @test */
    public function it_parses_spotify_url()
    {
        ['id' => $id, 'type' => $type] = Embedilite::from('spotify')->setSource(self::SPOTIFY_URL)->parseSource();

        $this->assertEquals(self::SPOTIFY_ID, $id);
        $this->assertEquals(self::SPOTIFY_TYPE, $type);
    }

    /** @test */
    public function it_renders_spotify_embed()
    {
        $embed = Embedilite::from('spotify')->setSource(self::SPOTIFY_URL)->toHtml();
        $expected = View::make('embedilite::spotify', ['id' => self::SPOTIFY_ID, 'type' => self::SPOTIFY_TYPE])->render();

        $this->assertStringContainsString($expected, $embed);
    }

    /** @test */
    public function it_throws_exception_when_rendering_invalid_spotify_source()
    {
        $this->expectException(InvalidEmbedSource::class);

        Embedilite::from('spotify')->setSource('')->toHtml();
    }
}
