<?php

namespace Cassarco\Lark\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Cassarco\Lark\Lark
 */
class Lark extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Cassarco\Lark\Lark::class;
    }
}
