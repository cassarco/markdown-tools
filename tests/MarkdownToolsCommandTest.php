<?php

use Cassarco\MarkdownTools\MarkdownFile;

use function Pest\testDirectory;

beforeEach(closure: function () {
    config()->set('markdown-tools.schemes', [
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

it('can run the markdown-tools command', function () {
    $this->artisan('markdown-tools:process')
        ->expectsOutput('Your schemes have all been processed successfully.')
        ->assertSuccessful();
});
