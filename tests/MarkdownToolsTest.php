<?php

use Cassarco\MarkdownTools\Exceptions\NoSchemesDefinedException;
use Cassarco\MarkdownTools\Facades\MarkdownTools;
use Cassarco\MarkdownTools\Tests\Fixtures\TestMarkdownFileHandler;

use function Pest\testDirectory;

it('can be instantiated', function () {
    expect(new MarkdownTools())->toBeInstanceOf(MarkdownTools::class);
});

it('can be called using a facade', function () {
    config()->set('markdown-tools.schemes', [
        [
            'path' => testDirectory('markdown/hello-world.md'),
            'handler' => TestMarkdownFileHandler::class,
        ],
    ]);

    MarkdownTools::process();
})->throwsNoExceptions();

it('needs at least one scheme to function', function () {
    config()->set('markdown-tools', []);

    MarkdownTools::process();
})->throws(NoSchemesDefinedException::class);

it('verifies that each scheme has a path', function () {
    config()->set('markdown-tools.schemes', [
        'one' => [],
    ]);

    MarkdownTools::process();
})->throws("Scheme 'one' must have a path");

it('verifies that each scheme path is not empty', function () {
    config()->set('markdown-tools.schemes', [
        'one' => [
            'path' => '',
        ],
    ]);

    MarkdownTools::process();
})->throws('The path in one must not be empty');
