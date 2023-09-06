<?php

namespace Carlcassar\Lark\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Carlcassar\Lark\Lark
 */
class Lark extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Carlcassar\Lark\Lark::class;
    }
}
