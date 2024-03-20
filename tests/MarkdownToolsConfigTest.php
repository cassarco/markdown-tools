<?php

use Cassarco\MarkdownTools\Exceptions\MarkdownToolsInvalidSchemeException;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsNoSchemesDefinedException;
use Cassarco\MarkdownTools\MarkdownToolsConfig;

it('throws an exception when no schemes are found', function () {
    config()->set('markdown-tools', []);

    new MarkdownToolsConfig();
})->throws(MarkdownToolsNoSchemesDefinedException::class);

it('throws an exception if a scheme does not have a path key', function () {
    config()->set('markdown-tools.schemes', [[]]);

    new MarkdownToolsConfig();
})->throws(MarkdownToolsInvalidSchemeException::class);
