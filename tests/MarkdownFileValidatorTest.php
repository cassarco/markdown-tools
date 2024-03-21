<?php

use Cassarco\MarkdownTools\Config;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsConversionException;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use Cassarco\MarkdownTools\MarkdownFile;
use Cassarco\MarkdownTools\MarkdownFileValidator;
use Cassarco\MarkdownTools\Scheme;

use function Pest\testDirectory;

it('can validate front-matter keys with laravel validation rules',
    /* @throws MarkdownToolsConversionException|MarkdownToolsValidationException */ function () {
        $file = new MarkdownFile(testDirectory('markdown/hello-world.md'),
            new Scheme(new Config([
                'rules' => [
                    'title' => 'required',
                ],
            ]))
        );

        (new MarkdownFileValidator())->withRules(['title' => 'required'])->validate($file);
    })->throws('hello-world.md: The title field is required.');
