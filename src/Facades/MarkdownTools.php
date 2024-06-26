<?php

namespace Cassarco\MarkdownTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Cassarco\MarkdownTools\MarkdownTools
 */
class MarkdownTools extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Cassarco\MarkdownTools\MarkdownTools::class;
    }
}
