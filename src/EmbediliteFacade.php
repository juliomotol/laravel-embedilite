<?php

namespace JulioMotol\Embedilite;

use Illuminate\Support\Facades\Facade;
use JulioMotol\Embedilite\Contracts\Factory;

/**
 * @method static \JulioMotol\Embedilite\Contracts\Provider from(string $driver)
 * @see \JulioMotol\Embedilite\EmbediliteManager
 */
class EmbediliteFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
