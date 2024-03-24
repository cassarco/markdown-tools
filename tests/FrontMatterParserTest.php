<?php

use Cassarco\MarkdownTools\Config;
use Cassarco\MarkdownTools\MarkdownFile;
use Cassarco\MarkdownTools\Scheme;

use function Pest\testDirectory;

it('can accept yaml front-matter parse flags', function () {
    $scheme = new Scheme(new Config([
        'path' => testDirectory('markdown/front-matter.md'),
    ]));

    /** @var MarkdownFile $file */
    $file = $scheme->markdownFiles()->first();

    expect($file->frontMatter())->toEqual([
        'title' => 'Some Title',
        'tags' => [
            0 => 'one',
            1 => 'two',
            2 => 'three',
        ],
        'date' => Date::parse('2018-08-10 19:19:00')->toDateTimeImmutable(),
    ]);

    config()->set('markdown-tools.common-mark.front-matter.yaml-parse-flags', 0);

    /** @var MarkdownFile $file */
    $file = $scheme->markdownFiles()->first();

    expect($file->frontMatter())->toEqual([
        'title' => 'Some Title',
        'tags' => [
            0 => 'one',
            1 => 'two',
            2 => 'three',
        ],
        'date' => Date::parse('2018-08-10 19:19:00')->unix(),
    ]);
});
