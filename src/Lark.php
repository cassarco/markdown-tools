<?php

namespace Cassarco\MarkdownTools;

use Illuminate\Support\Collection;

class MarkdownTools
{
    protected MarkdownToolsConfig $config;

    public function __construct()
    {
        $this->config = new MarkdownToolsConfig();
    }

    public function handle(): void
    {
        $this->config->schemes()
            ->each(fn (MarkdownToolsScheme $scheme) => $scheme->handle());
    }

    public function schemes(): Collection
    {
        return $this->config->schemes();
    }
}
