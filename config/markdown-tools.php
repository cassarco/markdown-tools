<?php

use Cassarco\MarkdownTools\MarkdownFile;
use Symfony\Component\Yaml\Yaml;

return [

    /*
    |--------------------------------------------------------------------------
    | Schemes
    |--------------------------------------------------------------------------
    |
    | Configure as many "schemes" as you like. Each scheme should contain a
    | path to a single markdown file or a folder containing markdown files.
    |
    */

    'schemes' => [

        // Give each scheme a name for your own organisation.
        'markdown' => [

            // Give the path to a folder of markdown files or a single markdown file.
            'path' => resource_path('markdown'),

            // Specify the validation rules for front-matter properties.
            'rules' => [
                // 'title' => 'required',
            ],

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

    /*
    |--------------------------------------------------------------------------
    | League/Commonmark Settings
    |--------------------------------------------------------------------------
    |
    | Configure settings for League Commonmark and its extensions.
    |
    */

    'common-mark' => [

        'heading_permalink' => [
            'symbol' => '#',
            'html_class' => '',
            'aria_hidden' => false,
            'id_prefix' => '',
            'fragment_prefix' => '',
        ],

        'table_of_contents' => [
            'html_class' => 'table-of-contents',
            'position' => 'top',
            'style' => 'bullet',
            'min_heading_level' => 1,
            'max_heading_level' => 6,
            'normalize' => 'relative',
            'placeholder' => null,
        ],

        'wikilinks' => [],

        'front-matter' => [
            'yaml-parse-flags' => Yaml::PARSE_DATETIME,
        ],
    ],
];
