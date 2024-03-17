<?php

use Carlcassar\Lark\MarkdownFile;
use Carlcassar\Lark\LarkFrontMatterKeyOrder;

// config for Carlcassar/Lark
return [
    'present' => [
        'path' => 'resources/markdown/present.md',
    ],
    'articles' => [
        'path' => 'resources/markdown',
        'validation' => [
            'rules' => [
                'title' => 'required',
                'slug',
                'author',
                'description',
                'tags',
                'image',
                'link',
                'published_at',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
            'order' => LarkFrontMatterKeyOrder::RuleOrder,
        ],
        'handler' => function(MarkdownFile $file) {
            echo($file->filename());
        },
    ],
];
