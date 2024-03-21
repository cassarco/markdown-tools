<?php

use Cassarco\MarkdownTools\Enums\FrontMatterKeyOrder;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use Cassarco\MarkdownTools\MarkdownFile;
use Cassarco\MarkdownTools\MarkdownFileValidator;

use function Pest\testDirectory;

it('can validate front-matter keys with laravel validator', /* @throws MarkdownToolsValidationException */ function () {
    $file = new MarkdownFile('hello-world.md', testDirectory('markdown/hello-world.md'));

    (new MarkdownFileValidator($file, [
        'rules' => [
            'title' => 'required',
        ],
    ]))->validate();
})->throws(MarkdownToolsValidationException::class, 'hello-world.md: The title field is required.');

it('can validate that the front-matter keys follow the validation rules order',
    /* @throws MarkdownToolsValidationException */ function () {
        $file = new MarkdownFile('front-matter.md', testDirectory('markdown/front-matter.md'));

        (new MarkdownFileValidator($file, [
            'rules' => [
                'tags',
                'title',
            ],
            'order' => FrontMatterKeyOrder::RuleOrder,
        ]))->validate();
    })->throws(MarkdownToolsValidationException::class,
        'front-matter.md: Keys are not in the correct order: tags, title');
