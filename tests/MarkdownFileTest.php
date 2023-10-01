<?php

use Carlcassar\Lark\Lark;
use Carlcassar\Lark\MarkdownFile;

use function Pest\testDirectory;

beforeEach(function () {
    config()->set('lark.path', testDirectory('markdown'));
});

it('can get the pathname for a file', function () {
    /** @var MarkdownFile $markdownFile */
    $markdownFile = (new Lark())->getMarkdownFiles()->first();

    expect($markdownFile->pathname())->toBe('tests/markdown/example.md');
});

it('can get the filename for a file', function () {
    /** @var MarkdownFile $markdownFile */
    $markdownFile = (new Lark())->getMarkdownFiles()->first();

    expect($markdownFile->filename())->toBe('example.md');
});

it('can get the markdown content for a file', function () {
    /** @var MarkdownFile $markdownFile */
    $markdownFile = (new Lark())->getMarkdownFiles()->first();

    expect($markdownFile->markdown())->toEqual(
        file_get_contents('tests/markdown/example.md')
    );
});

it('can get the html content for a file', function () {
    /** @var MarkdownFile $markdownFile */
    $markdownFile = (new Lark())->getMarkdownFiles()->first();

    expect($markdownFile->html())->toEqual(
        '<h1>An Example Markdown File</h1>'
    );
});

it('can get the front-matter data for a file', function () {
    /** @var MarkdownFile $markdownFile */
    $markdownFile = (new Lark())->getMarkdownFiles()->get(1);

    expect($markdownFile->frontMatter())->toEqual([
        'title' => 'Some Title',
        'tags' => [
            0 => 'one',
            1 => 'two',
            2 => 'three',
        ],
    ]);
});
