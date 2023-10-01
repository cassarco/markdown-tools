<?php

namespace Carlcassar\Lark;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\SplFileInfo;

class Lark
{
    private Filesystem $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    public function getPath()
    {
        return config('lark.path');
    }

    public function getMarkdownFiles(): Collection
    {
        return collect($this->filesystem->files($this->getPath()))->map(function (SplFileInfo $splFileInfo) {
            return MarkdownFile::from($splFileInfo);
        });
    }

    public function getMarkdownFileCalled(string $filename): MarkdownFile
    {
        return $this->getMarkdownFiles()->firstOrFail(function (MarkdownFile $file) use ($filename) {
            return $file->filename() == $filename;
        });
    }
}
