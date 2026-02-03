<?php

use Cassarco\MarkdownTools\Config;
use Cassarco\MarkdownTools\Contracts\MarkdownFileHandler;
use Cassarco\MarkdownTools\Exceptions\InvalidConfigException;
use Cassarco\MarkdownTools\Tests\Fixtures\TestMarkdownFileHandler;
use Cassarco\MarkdownTools\Tests\Fixtures\TestMarkdownFileRules;

it('can be instantiated', function () {
    expect(new Config([]))->toBeInstanceOf(Config::class);
});

it('can get the path for a scheme', function () {
    $config = new Config([
        'path' => $path = 'some/path',
    ]);

    expect($config->path())->toBe($path);
});

it('can get rules from a class implementing MarkdownFileRules', function () {
    $config = new Config([
        'rules' => TestMarkdownFileRules::class,
    ]);

    expect($config->rules())->toBe(['title' => 'required']);
});

it('can get rules from an array', function () {
    $config = new Config([
        'rules' => $rules = ['title' => 'required'],
    ]);

    expect($config->rules())->toBe($rules);
});

it('returns empty rules when rules not specified', function () {
    expect((new Config([]))->rules())->toBe([]);
});

it('throws exception when rules class does not exist', function () {
    $config = new Config([
        'rules' => 'NonExistentClass',
    ]);

    $config->rules();
})->throws(InvalidConfigException::class, 'does not exist');

it('throws exception when rules class does not implement interface', function () {
    $config = new Config([
        'rules' => stdClass::class,
    ]);

    $config->rules();
})->throws(InvalidConfigException::class, 'must implement');

it('can get a handler from a class implementing MarkdownFileHandler', function () {
    $config = new Config([
        'handler' => TestMarkdownFileHandler::class,
    ]);

    expect($config->handler())->toBeInstanceOf(MarkdownFileHandler::class);
    expect($config->handler())->toBeInstanceOf(TestMarkdownFileHandler::class);
});

it('throws exception when handler not specified', function () {
    $config = new Config([]);

    $config->handler();
})->throws(InvalidConfigException::class, 'Handler class is required');

it('throws exception when handler class does not exist', function () {
    $config = new Config([
        'handler' => 'NonExistentHandler',
    ]);

    $config->handler();
})->throws(InvalidConfigException::class, 'does not exist');

it('throws exception when handler class does not implement interface', function () {
    $config = new Config([
        'handler' => stdClass::class,
    ]);

    $config->handler();
})->throws(InvalidConfigException::class, 'must implement');
