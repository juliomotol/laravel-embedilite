<?php

namespace JulioMotol\Embedilite\Tests\Providers;

use Illuminate\Support\Facades\View;
use JulioMotol\Embedilite\EmbediliteFacade as Embedilite;
use JulioMotol\Embedilite\Exceptions\InvalidEmbedSource;
use JulioMotol\Embedilite\Tests\Support\SpotifySource;
use JulioMotol\Embedilite\Tests\TestCase;

class SpotifyProviderTest extends TestCase
{
    /** @test */
    public function it_validates_spotify_url()
    {
        $this->assertTrue(Embedilite::from('spotify')->validateSource(SpotifySource::URL));
    }

    /** @test */
    public function it_validates_spotify_uri()
    {
        $this->assertTrue(Embedilite::from('spotify')->validateSource(SpotifySource::URI));
    }

    /** @test */
    public function it_validates_invalid_spotify_source()
    {
        $this->assertFalse(Embedilite::from('spotify')->validateSource(''));
    }

    /** @test */
    public function it_parses_spotify_url()
    {
        ['id' => $id, 'type' => $type] = Embedilite::from('spotify')->setSource(SpotifySource::URL)->parseSource();

        $this->assertEquals(SpotifySource::ID, $id);
        $this->assertEquals(SpotifySource::TYPE, $type);
    }

    /** @test */
    public function it_renders_spotify_embed()
    {
        $embed = Embedilite::from('spotify')->setSource(SpotifySource::URL)->toHtml();
        $expected = View::make('embedilite::spotify', ['id' => SpotifySource::ID, 'type' => SpotifySource::TYPE])->render();

        $this->assertStringContainsString($expected, $embed);
    }

    /** @test */
    public function it_throws_exception_when_rendering_invalid_spotify_source()
    {
        $this->expectException(InvalidEmbedSource::class);

        Embedilite::from('spotify')->setSource('')->toHtml();
    }
}
