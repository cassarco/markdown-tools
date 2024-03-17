<?php

use Cassarco\Lark\LarkScheme;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

use function Pest\testDirectory;

beforeEach(function () {
    $this->scheme = new LarkScheme(testDirectory('markdown')); /* @phpstan-ignore-line */
});

it('can get the pathname for a file', function () {
    $markdownFile = $this->scheme->markdownFileCalled('hello-world.md'); /* @phpstan-ignore-line */

    expect($markdownFile->pathname())->toBe('tests/markdown/hello-world.md');
});

it('can get the filename for a file', function () {
    $markdownFile = $this->scheme->markdownFileCalled('hello-world.md'); /* @phpstan-ignore-line */

    expect($markdownFile->filename())->toBe('hello-world.md');
});

it('can get the markdown content for a file', /* @throws FileNotFoundException */ function () {
    $markdownFile = $this->scheme->markdownFileCalled('hello-world.md'); /* @phpstan-ignore-line */

    expect($markdownFile->markdown())->toEqual(
        file_get_contents('tests/markdown/hello-world.md')
    );
});

it('can get the html content for a file', function () {
    $markdownFile = $this->scheme->markdownFileCalled('hello-world.md'); /* @phpstan-ignore-line */

    expect($markdownFile->html())->toEqual(
        '<p>Hello World!</p>'
    );
});

it('can get the front-matter data for a file', function () {
    $markdownFile = $this->scheme->markdownFileCalled('front-matter.md'); /* @phpstan-ignore-line */

    expect($markdownFile->frontMatter())->toEqual([
        'title' => 'Some Title',
        'tags' => [
            0 => 'one',
            1 => 'two',
            2 => 'three',
        ],
    ]);
});

it('can return the table of contents for a markdown file', function () {
    $markdownFile = $this->scheme->markdownFileCalled('toc.md'); /* @phpstan-ignore-line */

    $expectedToc = <<<'HTML'
<ul class="table-of-contents">
<li>
<a href="#title">Title</a>
<ul>
<li>
<a href="#heading">Heading</a>
</li>
<li>
<a href="#subheading">SubHeading</a>
</li>
</ul>
</li>
</ul>
HTML;

    expect($markdownFile->toc())->toBe($expectedToc);
});
