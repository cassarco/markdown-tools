<?php

namespace Cassarco\MarkdownTools\Tests\Fixtures;

use Cassarco\MarkdownTools\Contracts\MarkdownFileRules;

class TestMarkdownFileRules implements MarkdownFileRules
{
    public function __invoke(): array
    {
        return [
            'title' => 'required',
        ];
    }
}
