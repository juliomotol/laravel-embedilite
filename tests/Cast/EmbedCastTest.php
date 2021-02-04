<?php

namespace JulioMotol\Embedilite\Tests\Cast;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use JulioMotol\Embedilite\Providers\SpotifyProvider;
use JulioMotol\Embedilite\Tests\EmbedCastModel;
use JulioMotol\Embedilite\Tests\Support\SpotifySource;
use JulioMotol\Embedilite\Tests\TestCase;

class EmbedCastTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    /** @test */
    public function it_casts_embed()
    {
        $model = EmbedCastModel::create(['source' => SpotifySource::URL]);

        $this->assertInstanceOf(SpotifyProvider::class, $model->embed);
    }

    /**
     * @param  $app
     */
    protected function setUpDatabase(Application $app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('embed_cast_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source')->nullable();
        });
    }
}
