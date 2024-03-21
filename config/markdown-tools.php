<?php

use Cassarco\MarkdownTools\Enums\FrontMatterKeyOrder;
use Cassarco\MarkdownTools\MarkdownFile;

return [

    /*
    |--------------------------------------------------------------------------
    | MarkdownTools Schemes
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many markdown-tools "schemes disks" as you wish. Each
    | scheme will contain the configuration for a folder containing that
    | contains markdown files or alternatively a single markdown file.
    |
    | Visit the documentation for more information.
    |
    */

    'schemes' => [

        // Give each scheme a name for your own organisation.
        'articles' => [

            // Give the path to a folder of markdown files or a single markdown file.
            'path' => 'resources/markdown',

            // Specify the validation rules for front-matter properties.
            'validate-front-matter' => [
                'title' => 'required',
            ],

            // Specify validation for the order of front-matter properties.
            'sort-front-matter' => FrontMatterKeyOrder::None,

            // Define a handler for each markdown file. You will have access to file:
            //  - front-matter values
            //  - markdown
            //  - html
            //  - htmlWithToc
            //  - toc
            'handler' => function (MarkdownFile $file) {
                // Do Something with each Markdown File.
            },
        ],
    ],
];
