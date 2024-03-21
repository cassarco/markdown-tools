<?php

use Cassarco\MarkdownTools\MarkdownFile;
use Cassarco\MarkdownTools\Scheme;
use Illuminate\Support\Collection;

use function Pest\testDirectory;

it('can be initialised with a path', function () {
    $scheme = new Scheme(
        path: testDirectory('markdown')
    );

    expect($scheme)->toBeInstanceOf(Scheme::class);
});

it('can get a collection of markdown files for the scheme', function () {
    $scheme = new Scheme(
        path: testDirectory('markdown/articles'),
    );

    expect($scheme)->toBeInstanceOf(Scheme::class)
        ->and($files = $scheme->markdownFiles())->toBeInstanceOf(Collection::class)
        ->and($files->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($files->count())->toBe(2);
});

it('can get one file for the scheme', function () {
    $scheme = new Scheme(
        path: testDirectory('markdown/hello-world.md'),
    );

    expect($scheme)->toBeInstanceOf(Scheme::class)
        ->and($files = $scheme->markdownFiles())->toBeInstanceOf(Collection::class)
        ->and($files->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($files->count())->toBe(1);
});
