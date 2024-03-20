<?php

use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use Cassarco\MarkdownTools\MarkdownToolsFrontMatterKeyOrder;
use Cassarco\MarkdownTools\MarkdownToolsMarkdownFileValidator;
use Cassarco\MarkdownTools\MarkdownFile;

use function Pest\testDirectory;

it('can validate front-matter keys with laravel validator', /* @throws MarkdownToolsValidationException */ function () {
    $file = new MarkdownFile('hello-world.md', testDirectory('markdown/hello-world.md'));

    (new MarkdownToolsMarkdownFileValidator($file, [
        'rules' => [
            'title' => 'required',
        ],
    ]))->validate();
})->throws(MarkdownToolsValidationException::class, 'hello-world.md: The title field is required.');

it('can validate that the front-matter keys follow the validation rules order', /* @throws MarkdownToolsValidationException */ function () {
    $file = new MarkdownFile('front-matter.md', testDirectory('markdown/front-matter.md'));

    (new MarkdownToolsMarkdownFileValidator($file, [
        'rules' => [
            'tags',
            'title',
        ],
        'order' => MarkdownToolsFrontMatterKeyOrder::RuleOrder,
    ]))->validate();
})->throws(MarkdownToolsValidationException::class, 'front-matter.md: Keys are not in the correct order: tags, title');
