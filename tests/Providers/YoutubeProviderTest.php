<?php

namespace JulioMotol\Embedilite\Tests\Providers;

use Illuminate\Support\Facades\View;
use JulioMotol\Embedilite\EmbediliteFacade as Embedilite;
use JulioMotol\Embedilite\Exceptions\InvalidEmbedSource;
use JulioMotol\Embedilite\Tests\TestCase;
use JulioMotol\Embedilite\Tests\TestSupport\TestSources\YoutubeSource;

class YoutubeProviderTest extends TestCase
{
    /** @test */
    public function it_validates_url()
    {
        $this->assertTrue(Embedilite::from('youtube')::validateSource(YoutubeSource::URL));
    }

    /** @test */
    public function it_validates_invalid_source()
    {
        $this->assertFalse(Embedilite::from('youtube')::validateSource(''));
    }

    /** @test */
    public function it_parses_url()
    {
        $source = Embedilite::from('youtube')
            ->setSource(YoutubeSource::URL)
            ->parseSource();

        $this->assertStringContainsString(YoutubeSource::EMBED_URL, $source);
    }

    /** @test */
    public function it_parses_url_with_options()
    {
        $options = [
            'autoplay' => true,
            'controls' => false,
        ];

        $source = Embedilite::from('youtube')
            ->setSource(YoutubeSource::URL)
            ->setOptions($options)
            ->parseSource();

        $this->assertStringContainsString(YoutubeSource::EMBED_URL, $source);
        $this->assertStringContainsString('autoplay', $source);
        $this->assertStringContainsString('controls', $source);
    }

    /** @test */
    public function it_renders_embed()
    {
        $embed = Embedilite::from('youtube')
            ->setSource(YoutubeSource::URL)
            ->toHtml();
        $expected = View::make('embedilite::youtube', ['source' => YoutubeSource::EMBED_URL . '?' . http_build_query(['origin' => url('/')])])->render();

        $this->assertStringContainsString($expected, $embed);
        $this->assertStringContainsString(urlencode(url('/')), $embed);
    }

    /** @test */
    public function it_renders_embed_with_options()
    {
        $options = [
            'autoplay' => true,
            'controls' => false,
        ];

        $embed = Embedilite::from('youtube')
            ->setSource(YoutubeSource::URL)
            ->setOptions($options)
            ->toHtml();
        $expected = View::make('embedilite::youtube', ['source' => YoutubeSource::EMBED_URL . '?' . http_build_query(array_merge(['origin' => url('/')], $options))])->render();

        $this->assertStringContainsString($expected, $embed);
        $this->assertStringContainsString(urlencode(url('/')), $embed);
        $this->assertStringContainsString('autoplay', $embed);
        $this->assertStringContainsString('controls', $embed);
    }

    /** @test */
    public function it_throws_exception_when_rendering_invalid_source()
    {
        $this->expectException(InvalidEmbedSource::class);

        Embedilite::from('youtube')
            ->setSource('')
            ->toHtml();
    }
}
