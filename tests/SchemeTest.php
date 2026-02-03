<?php

use Cassarco\MarkdownTools\Config;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use Cassarco\MarkdownTools\MarkdownFile;
use Cassarco\MarkdownTools\Scheme;
use Cassarco\MarkdownTools\Tests\Fixtures\TestMarkdownFileHandler;
use Illuminate\Support\Collection;

use function Pest\testDirectory;

it('can be initialised', function () {
    $scheme = new Scheme(new Config([]));

    expect($scheme)->toBeInstanceOf(Scheme::class);
});

it('can get a collection of markdown files for the scheme', function () {
    $scheme = new Scheme(
        new Config(['path' => testDirectory('markdown/articles')])
    );

    expect($scheme)->toBeInstanceOf(Scheme::class)
        ->and($files = $scheme->markdownFiles())->toBeInstanceOf(Collection::class)
        ->and($files->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($files->count())->toBe(2);
});

it('can get one file for the scheme', function () {
    $scheme = new Scheme(
        new Config(['path' => testDirectory('markdown/hello-world.md')])
    );

    expect($scheme)->toBeInstanceOf(Scheme::class)
        ->and($files = $scheme->markdownFiles())->toBeInstanceOf(Collection::class)
        ->and($files->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($files->count())->toBe(1);
});

it('can process the scheme', /** @throws MarkdownToolsValidationException */ function () {
    $scheme = new Scheme(
        new Config([
            'path' => testDirectory('markdown/articles'),
            'handler' => TestMarkdownFileHandler::class,
        ])
    );

    $scheme->process();
})->throwsNoExceptions();
