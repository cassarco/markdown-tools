<?php

use Carlcassar\Lark\Lark;
use Carlcassar\Lark\MarkdownFile;
use Illuminate\Support\Collection;

use function Pest\testDirectory;

beforeEach(closure: function () {
    config()->set('lark.path', testDirectory('markdown'));
});

it('is alive', function () {
    expect(new Lark())->toBeInstanceOf(Lark::class);
});

it('can get the correct path from config', function () {
    expect((new Lark)->getPath())->toBe('tests/markdown');
});

it('can be called using a facade', function () {
    expect(\Carlcassar\Lark\Facades\Lark::getPath())->toBeString();
});

it('knows which path the markdown files are in', function () {
    config()->set('lark.path', $path = 'some/random/path');

    expect((new Lark())->getPath())
        ->toBe($path)
        ->and((new Lark())->getPath())
        ->not->toBe('some/other/path');
});

it('can get a collection of markdown files', function () {
    $markdownFiles = (new Lark)->getMarkdownFiles();

    expect($markdownFiles)->toBeInstanceOf(Collection::class)
        ->and($markdownFiles->first())->toBeInstanceOf(MarkdownFile::class)
        ->and($markdownFiles->count())->toBe(2);

    /** @var MarkdownFile $file */
    expect($markdownFiles->first()->filename())->toBe('example.md');
});

it('can get a single markdown file by name', function () {
    $markdownFile = (new Lark)->getMarkdownFileCalled('front-matter.md');

    expect($markdownFile)->toBeInstanceOf(MarkdownFile::class);
    expect($markdownFile->filename())->toBe('front-matter.md');
});
