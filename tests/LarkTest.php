<?php

use Carlcassar\Lark\Lark;
use Carlcassar\Lark\LarkScheme;
use Illuminate\Support\Collection;

beforeEach(closure: function () {
    config()->set('lark.schemes', [
        [
            'path' => '',
        ],
    ]);
});

it('is alive', function () {
    expect(new Lark())->toBeInstanceOf(Lark::class);
});

it('can be called using a facade', function () {
    \Carlcassar\Lark\Facades\Lark::schemes();
})->throwsNoExceptions();

it('can get a collection of import schemes', function () {
    config()->set('lark.schemes', [
        'articles' => ['path' => ''],
        'tags' => ['path' => ''],
    ]);

    $schemes = (new Lark)->schemes();

    expect($schemes)->toBeInstanceOf(Collection::class)
        ->and($schemes->first())->toBeInstanceOf(LarkScheme::class)
        ->and($schemes->count())->toBe(2);
});
