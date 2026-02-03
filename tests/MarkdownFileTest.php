<?php

use Cassarco\MarkdownTools\Config;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use Cassarco\MarkdownTools\MarkdownFile;
use Cassarco\MarkdownTools\Scheme;
use Cassarco\MarkdownTools\Tests\Fixtures\TestMarkdownFileHandler;

use function Pest\testDirectory;

it('can get the markdown content for a file', function () {
    $scheme = new Scheme(new Config([
        'path' => testDirectory('markdown/hello-world.md'),
    ]));

    /** @var MarkdownFile $file */
    $file = $scheme->markdownFiles()->first();

    expect($file->markdown())->toEqual(
        file_get_contents('tests/markdown/hello-world.md')
    );
});

it('can get the html content for a file', function () {
    $scheme = new Scheme(new Config([
        'path' => testDirectory('markdown/hello-world.md'),
    ]));

    /** @var MarkdownFile $file */
    $file = $scheme->markdownFiles()->first();

    expect($file->html())->toEqual(
        '<p>Hello World!</p>'
    );
});

it('can get the front-matter data for a file', function () {
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
});

it('can return the table of contents for a markdown file', function () {
    $scheme = new Scheme(new Config([
        'path' => testDirectory('markdown/toc.md'),
    ]));

    $expectedToc = <<<'HTML'
<ul class="table-of-contents">
<li><a href="#title">Title</a>
<ul>
<li><a href="#heading">Heading</a></li>
<li><a href="#subheading">SubHeading</a></li>
</ul>
</li>
</ul>
HTML;

    /** @var MarkdownFile $file */
    $file = $scheme->markdownFiles()->first();

    expect($file->toc())->toBe($expectedToc);
});

it('can return the html with embedded table of contents for a markdown file', function () {
    $scheme = new Scheme(new Config([
        'path' => testDirectory('markdown/toc.md'),
    ]));

    $expectedToc = <<<'HTML'
<ul class="table-of-contents">
<li><a href="#title">Title</a>
<ul>
<li><a href="#heading">Heading</a></li>
<li><a href="#subheading">SubHeading</a></li>
</ul>
</li>
</ul>
<h1><a id="title" href="#title" class="" title="Permalink">#</a>Title</h1>
<p>Some text.</p>
<h2><a id="heading" href="#heading" class="" title="Permalink">#</a>Heading</h2>
<p>Some text.</p>
<h2><a id="subheading" href="#subheading" class="" title="Permalink">#</a>SubHeading</h2>
<p>Some text.</p>
HTML;

    /** @var MarkdownFile $file */
    $file = $scheme->markdownFiles()->first();

    expect($file->htmlWithToc())->toBe($expectedToc);
});

it('can returns an empty string for the table of contents of a markdown file with no table of contents', function () {
    $scheme = new Scheme(new Config([
        'path' => testDirectory('markdown/hello-world.md'),
    ]));

    /** @var MarkdownFile $file */
    $file = $scheme->markdownFiles()->first();

    expect($file->toc())->toBe('');
});

it('can process itself', /** @throws MarkdownToolsValidationException */ function () {
    $scheme = new Scheme(new Config([
        'path' => testDirectory('markdown/hello-world.md'),
        'handler' => TestMarkdownFileHandler::class,
    ]));

    /** @var MarkdownFile $file */
    $file = $scheme->markdownFiles()->first();

    $file->process();
})->throwsNoExceptions();
