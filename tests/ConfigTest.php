<?php

use Cassarco\MarkdownTools\Config;
use Cassarco\MarkdownTools\Exceptions\InvalidSchemeException;
use Cassarco\MarkdownTools\Exceptions\NoSchemesDefinedException;

it('throws an exception when no schemes are found', function () {
    config()->set('markdown-tools', []);

    new Config();
})->throws(NoSchemesDefinedException::class);

it('throws an exception if a scheme does not have the correct keys', function () {
    config()->set('markdown-tools.schemes', [[]]);

    new Config();
})->throws(InvalidSchemeException::class);
