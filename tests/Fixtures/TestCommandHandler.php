<?php

namespace Cassarco\MarkdownTools\Tests\Fixtures;

use Cassarco\MarkdownTools\Contracts\MarkdownFileHandler;
use Cassarco\MarkdownTools\MarkdownFile;

use function Laravel\Prompts\info;

class TestCommandHandler implements MarkdownFileHandler
{
    public function __invoke(MarkdownFile $file): void
    {
        info("Processing {$file->frontMatter()['title']}");
    }
}
