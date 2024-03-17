<?php

use Cassarco\Lark\Exceptions\LarkInvalidSchemeException;
use Cassarco\Lark\Exceptions\LarkNoSchemesDefinedException;
use Cassarco\Lark\LarkConfig;

it('throws an exception when no schemes are found', function () {
    config()->set('lark', []);

    new LarkConfig();
})->throws(LarkNoSchemesDefinedException::class);

it('throws an exception if a scheme does not have a path key', function () {
    config()->set('lark.schemes', [[]]);

    new LarkConfig();
})->throws(LarkInvalidSchemeException::class);
