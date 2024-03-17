<?php

namespace Carlcassar\Lark;

use Carlcassar\Lark\Exceptions\LarkValidationException;
use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\SplFileInfo;

class LarkScheme
{
    private Filesystem $filesystem;

    private string $path;

    private Closure $handler;

    private array $validation = [];

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->filesystem = new Filesystem();
    }

    public function withValidation(array $validation)
    {
        $this->validation = $validation;
    }

    public function withHandler(Closure $handler)
    {
        $this->handler = $handler;
    }

    public function markdownFiles(): Collection
    {
        // If a directory path is specified
        if ($this->filesystem->isDirectory($this->path)) {
            $files = $this->filesystem->files($this->path);
        } // Else if a file path is specified
        else {
            $pathInfo = pathinfo($this->path);
            $files = $this->filesystem->files($pathInfo['dirname']);
            $files = array_filter($files, function (SplFileInfo $file) use ($pathInfo) {
                return $file->getFilename() == $pathInfo['basename'];
            });
        }

        return collect($files)->map(fn (SplFileInfo $splFileInfo) => MarkdownFile::from($splFileInfo));
    }

    /**
     * Get a single markdown file by its filename.
     */
    public function markdownFileCalled(string $filename): MarkdownFile
    {
        return $this->markdownFiles()->firstOrFail(function (MarkdownFile $file) use ($filename) {
            return $file->filename() == $filename;
        });
    }

    /**
     * @throws LarkValidationException
     */
    private function validate(MarkdownFile $file): void
    {
        (new LarkMarkdownFileValidator($file, $this->validation))->validate();
    }

    /**
     * @throws LarkValidationException
     */
    public function handle(): void
    {
        $this->markdownFiles()
            ->each(fn (MarkdownFile $file) => $this->validate($file))
            ->each(fn (MarkdownFile $file) => ($this->handler)($file));
    }
}
