<?php

use Cassarco\MarkdownTools\MarkdownToolsScheme;
use Cassarco\MarkdownTools\MarkdownFile;
use Illuminate\Support\Collection;

use function Pest\testDirectory;

it('can be initialised with a path', function () {
    $scheme = new MarkdownToolsScheme(
        path: testDirectory('markdown')
    );

    expect($scheme)->toBeInstanceOf(MarkdownToolsScheme::class);
});

it('can get a collection of markdown files for the scheme', function () {
    $scheme = new MarkdownToolsScheme(
        path: testDirectory('markdown/articles'),
    );

    expect($scheme)->toBeInstanceOf(MarkdownToolsScheme::class)
        ->and($files = $scheme->markdownFiles())->toBeInstanceOf(Collection::class)
        ->and($files->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($files->count())->toBe(2);
});

it('can get one file for the scheme', function () {
    $scheme = new MarkdownToolsScheme(
        path: testDirectory('markdown/hello-world.md'),
    );

    expect($scheme)->toBeInstanceOf(MarkdownToolsScheme::class)
        ->and($files = $scheme->markdownFiles())->toBeInstanceOf(Collection::class)
        ->and($files->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($files->count())->toBe(1);
});
