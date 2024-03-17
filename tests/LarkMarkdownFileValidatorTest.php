<?php

use Cassarco\Lark\Exceptions\LarkValidationException;
use Cassarco\Lark\LarkFrontMatterKeyOrder;
use Cassarco\Lark\LarkMarkdownFileValidator;
use Cassarco\Lark\MarkdownFile;

use function Pest\testDirectory;

it('can validate front-matter keys with laravel validator', /* @throws LarkValidationException */ function () {
    $file = new MarkdownFile('hello-world.md', testDirectory('markdown/hello-world.md'));

    (new LarkMarkdownFileValidator($file, [
        'rules' => [
            'title' => 'required',
        ],
    ]))->validate();
})->throws(LarkValidationException::class, 'hello-world.md: The title field is required.');

it('can validate that the front-matter keys follow the validation rules order', /* @throws LarkValidationException */ function () {
    $file = new MarkdownFile('front-matter.md', testDirectory('markdown/front-matter.md'));

    (new LarkMarkdownFileValidator($file, [
        'rules' => [
            'tags',
            'title',
        ],
        'order' => LarkFrontMatterKeyOrder::RuleOrder,
    ]))->validate();
})->throws(LarkValidationException::class, 'front-matter.md: Keys are not in the correct order: tags, title');
