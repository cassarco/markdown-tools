<?php

namespace Cassarco\MarkdownTools\Contracts;

use Cassarco\MarkdownTools\MarkdownFile;

interface MarkdownFileHandler
{
    public function __invoke(MarkdownFile $file): void;
}
