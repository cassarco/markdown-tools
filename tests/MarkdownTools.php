<?php

use Cassarco\MarkdownTools\MarkdownTools;
use Cassarco\MarkdownTools\MarkdownToolsScheme;
use Illuminate\Support\Collection;

beforeEach(closure: function () {
    config()->set('markdown-tools.schemes', [
        [
            'path' => '',
        ],
    ]);
});

it('is alive', function () {
    expect(new MarkdownTools())->toBeInstanceOf(MarkdownTools::class);
});

it('can be called using a facade', function () {
    \Cassarco\MarkdownTools\Facades\MarkdownTools::schemes();
})->throwsNoExceptions();

it('can get a collection of import schemes', function () {
    config()->set('markdown-tools.schemes', [
        'articles' => ['path' => ''],
        'tags' => ['path' => ''],
    ]);

    $schemes = (new MarkdownTools)->schemes();

    expect($schemes)->toBeInstanceOf(Collection::class)
        ->and($schemes->first())->toBeInstanceOf(MarkdownToolsScheme::class)
        ->and($schemes->count())->toBe(2);
});
