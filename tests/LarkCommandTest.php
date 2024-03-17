<?php

use Cassarco\Lark\MarkdownFile;

use function Pest\testDirectory;

beforeEach(closure: function () {
    config()->set('lark.schemes', [
        'articles' => [
            'path' => testDirectory('markdown/articles'),
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
            'handler' => function (MarkdownFile $file) {
                //
            },
            'sort' => 'rule-order',
        ],
    ]);
});

it('can run the lark command', function () {
    $this->artisan('lark:process')
        ->expectsOutput('Your Lark Schemes have all been processed successfully.')
        ->assertSuccessful();
});
