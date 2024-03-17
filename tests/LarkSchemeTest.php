<?php

use Cassarco\Lark\LarkScheme;
use Cassarco\Lark\MarkdownFile;
use Illuminate\Support\Collection;

use function Pest\testDirectory;

it('can be initialised with a path', function () {
    $scheme = new LarkScheme(
        path: testDirectory('markdown')
    );

    expect($scheme)->toBeInstanceOf(LarkScheme::class);
});

it('can get a collection of markdown files for the scheme', function () {
    $scheme = new LarkScheme(
        path: testDirectory('markdown/articles'),
    );

    expect($scheme)->toBeInstanceOf(LarkScheme::class)
        ->and($files = $scheme->markdownFiles())->toBeInstanceOf(Collection::class)
        ->and($files->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($files->count())->toBe(2);
});

it('can get one file for the scheme', function () {
    $scheme = new LarkScheme(
        path: testDirectory('markdown/hello-world.md'),
    );

    expect($scheme)->toBeInstanceOf(LarkScheme::class)
        ->and($files = $scheme->markdownFiles())->toBeInstanceOf(Collection::class)
        ->and($files->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($files->count())->toBe(1);
});
