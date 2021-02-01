<?php

namespace JulioMotol\Embedilite;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JulioMotol\Embedilite\Embedilite
 */
class EmbediliteFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'embedilite';
    }
}
