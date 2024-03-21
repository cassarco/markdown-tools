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
     * Get a single markdown file by its filename.
     */
    public function markdownFileCalled(string $filename): MarkdownFile
    {
        return $this->markdownFiles()->firstOrFail(function (MarkdownFile $file) use ($filename) {
            return $file->filename == $filename;
        });
    }

    public function markdownFiles(): Collection
    {
        $files = $this->loadFiles();

        return collect($files)->map(function (SplFileInfo $splFileInfo) {
            return new MarkdownFile(
                $splFileInfo->getFilename(),
                $splFileInfo->getPathname(),
                $this
            );
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

    /**
     * @throws MarkdownToolsValidationException
     */
    public function process(): void
    {
        $this->markdownFiles()->each(fn (MarkdownFile $file) => $file->process());

        //            ->each(fn (MarkdownFile $file) => $this->validate($file))
        //            ->each(fn (MarkdownFile $file) => ($this->config->handler())($file));
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    private function validate(MarkdownFile $file): void
    {
        (new MarkdownFileValidator($file, $this->config->frontMatterValidationRules()))->validate();
    }
}
