<?php

namespace Cassarco\MarkdownTools\Tests\Fixtures;

use Cassarco\MarkdownTools\Contracts\MarkdownFileHandler;
use Cassarco\MarkdownTools\MarkdownFile;

class TestMarkdownFileHandler implements MarkdownFileHandler
{
    public function __invoke(MarkdownFile $file): void
    {
        // No-op for testing
    }
}
