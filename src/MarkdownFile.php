<?php

namespace Cassarco\Lark;

use Cassarco\LeagueCommonmarkWikilinks\WikilinksExtension;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Output\RenderedContentInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Finder\SplFileInfo;

class MarkdownFile
{
    private string $filename;

    private string $pathname;

    private Filesystem $filesystem;

    private RenderedContentInterface $content;

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

    /**
     * @throws FileNotFoundException
     * @throws CommonMarkException
     */
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
        $crawler = new Crawler($this->htmlWithToc());
        $ulNodes = $crawler->filter('ul.table-of-contents');

        foreach ($ulNodes as $ulNode) {
            $ulNode->parentNode->removeChild($ulNode);
        }

        return trim($crawler->filter('body')->html());
    }

    public function htmlWithToc(): string
    {
        return trim($this->content->getContent());
    }

    public function frontMatter(): array
    {
        return $this->content->getDocument()->data['front_matter'] ?? [];
    }

    public function toc(): string
    {
        $crawler = new Crawler($this->htmlWithToc());
        $ulNodes = $crawler->filter('ul.table-of-contents');

        // TODO: Add a test for this code
        if($ulNodes->first()->count()) {
            return $ulNodes->first()->outerHtml();
        } else {
            return '';
        }
    }

    /**
     * @throws FileNotFoundException
     * @throws CommonMarkException
     */
    private function generateRenderedContent(): void
    {
        $environment = new Environment([
            'heading_permalink' => [
                'symbol' => '#',
                'html_class' => 'no-underline mr-2 text-gray-500',
                'aria_hidden' => false,
                'id_prefix' => '',
                'fragment_prefix' => '',
            ],
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new WikiLinksExtension());
        $environment->addExtension(new FrontMatterExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TableOfContentsExtension());

        $this->content = (new MarkdownConverter($environment))->convert($this->markdown());
    }
}
