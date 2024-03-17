<?php

use Carlcassar\Lark\LarkFrontMatterKeyOrder;
use Carlcassar\Lark\MarkdownFile;

// config for Carlcassar/Lark
return [
    'schemes' => [
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
            'handler' => function (MarkdownFile $file) {
                echo $file->filename();
            },
        ],
    ],
];
