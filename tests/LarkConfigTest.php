<?php

use Carlcassar\Lark\Exceptions\LarkInvalidSchemeException;
use Carlcassar\Lark\Exceptions\LarkNoSchemesDefinedException;
use Carlcassar\Lark\LarkConfig;

it('throws an exception when no schemes are found', function () {
    config()->set('lark', []);

    new LarkConfig();
})->throws(LarkNoSchemesDefinedException::class);

it('throws an exception if a scheme does not have a path key', function () {
    config()->set('lark.schemes', [[]]);

    new LarkConfig();
})->throws(LarkInvalidSchemeException::class);
