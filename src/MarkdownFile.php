<?php

namespace Carlcassar\Lark;

use Cassar\LeagueCommonmarkWikilinks\WikilinksExtension;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Output\RenderedContentInterface;
use Symfony\Component\Finder\SplFileInfo;

class MarkdownFile
{
    private string $filename;

    private string $pathname;

    protected Filesystem $filesystem;

    protected RenderedContentInterface $content;

    /**
     * @throws FileNotFoundException
     * @throws CommonMarkException
     */
    final public function __construct(string $filename, string $pathname)
    {
        $this->filename = $filename;
        $this->pathname = $pathname;

        $this->filesystem = new Filesystem();

        $this->generateRenderedContent();
    }

    public static function from(SplFileInfo $splFileInfo): static
    {
        return new static($splFileInfo->getFilename(), $splFileInfo->getPathname());
    }

    public function pathname(): string
    {
        return $this->pathname;
    }

    public function filename(): string
    {
        return $this->filename;
    }

    /**
     * @throws FileNotFoundException
     */
    public function markdown(): string
    {
        return $this->filesystem->get($this->pathname());
    }

    public function html(): string
    {
        return trim($this->content->getContent());
    }

    public function frontMatter(): array
    {
        return $this->content->getDocument()->data['front_matter'] ?? [];
    }

    /**
     * @throws FileNotFoundException
     * @throws CommonMarkException
     */
    private function generateRenderedContent(): void
    {
        $environment = new Environment([
            'wikilinks' => [],
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new WikiLinksExtension());
        $environment->addExtension(new FrontMatterExtension());

        $this->content = (new MarkdownConverter($environment))->convert($this->markdown());
    }
}
