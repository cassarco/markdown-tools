<?php

use Cassarco\MarkdownTools\Config;

it('can be instantiated', function () {
    expect(new Config([]))->toBeInstanceOf(Config::class);
});

it('can get the path for a scheme', function () {
    $config = new Config([
        'path' => $path = 'some/path',
    ]);

    expect($config->path())->toBe($path);
});

it('can get the rules for a scheme if they are specified', function () {
    $config = new Config([
        'rules' => $rules = [
            'title' => 'required',
        ],
    ]);

    expect($config->rules())->toBe($rules);
});

it('can get fallback rules for a scheme if rules are not specified', function () {
    expect((new Config([]))->rules())->toBe([]);
});

it('can get the handler for a scheme if it is specified', function () {
    $config = new Config([
        'handler' => $handler = function () {
            // Do Something
        },
    ]);

    expect($config->handler())->toBe($handler);
});

it('can get a default handler for a scheme if a handler is not specified', function () {
    expect((new Config([]))->handler())->toBeInstanceOf(Closure::class);
});
