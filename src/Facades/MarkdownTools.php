<?php

namespace Cassarco\MarkdownTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Cassarco\MarkdownTools\MarkdownTools
 */
class MarkdownTools extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Cassarco\MarkdownTools\MarkdownTools::class;
    }
}
