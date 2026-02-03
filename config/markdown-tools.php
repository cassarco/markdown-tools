<?php

use App\Actions\MarkdownFileHandler;
use App\Actions\MarkdownFileRules;
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
    | Publish the action stubs with: php artisan vendor:publish --tag=markdown-tools-actions
    |
    */

    'schemes' => [

        // Give your scheme a name.
        'default' => [

            // Give the path to a folder of markdown files or a single markdown file.
            'path' => resource_path('markdown'),

            // Specify validation rules for front-matter properties.
            'rules' => MarkdownFileRules::class,

            // Define a handler for each markdown file.
            'handler' => MarkdownFileHandler::class,
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
