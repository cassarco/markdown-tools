<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use File;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\SplFileInfo;

class Scheme
{
    public Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    public function process(): void
    {
        $this->markdownFiles()->each(fn (MarkdownFile $file) => $file->process());
    }

    public function markdownFiles(): Collection
    {
        $files = $this->loadFiles();

        return collect($files)->map(function (SplFileInfo $splFileInfo) {
            return new MarkdownFile($splFileInfo->getPathname(), $this);
        });
    }

    private function loadFiles(): array
    {
        // If a directory path is specified
        if (File::isDirectory($this->config->path())) {
            return File::files($this->config->path());
        }

        // If a markdown file path is specified
        $pathInfo = pathinfo($this->config->path());

        $files = File::files($pathInfo['dirname']);

        return array_filter($files, function (SplFileInfo $file) use ($pathInfo) {
            return $file->getFilename() == $pathInfo['basename'];
        });
    }
}
