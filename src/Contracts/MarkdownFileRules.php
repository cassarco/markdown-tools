<?php

namespace Cassarco\MarkdownTools\Contracts;

interface MarkdownFileRules
{
    public function __invoke(): array;
}
