<?php

namespace Cassarco\MarkdownTools;

use Cassarco\LeagueCommonmarkWikilinks\WikilinksExtension;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use File;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Output\RenderedContentInterface;
use Symfony\Component\DomCrawler\Crawler;

class MarkdownFile
{
    public string $filename;

    private string $pathname;

    private RenderedContentInterface $content;

    private Scheme $scheme;

    /**
     * @throws CommonMarkException
     */
    final public function __construct(string $filename, string $pathname, Scheme $scheme)
    {
        $this->filename = $filename;
        $this->pathname = $pathname;
        $this->scheme = $scheme;

        $this->generateRenderedContent();
    }

    /**
     * @throws CommonMarkException
     */
    private function generateRenderedContent(): void
    {
        $environment = new Environment([
            'wikilinks' => [],
            'heading_permalink' => [
                'symbol' => '#',
                'html_class' => 'no-underline mr-2 text-gray-500',
                'aria_hidden' => false,
                'id_prefix' => '',
                'fragment_prefix' => '',
            ],
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new FrontMatterExtension(new FrontMatterParser()));
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TableOfContentsExtension());
        $environment->addExtension(new WikiLinksExtension());

        $this->content = (new MarkdownConverter($environment))->convert($this->markdown());
    }

    public function markdown(): string
    {
        return File::get($this->pathname);
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

        // TODO: Add a test for this code.
        if ($ulNodes->first()->count()) {
            return $ulNodes->first()->outerHtml();
        } else {
            return '';
        }
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    public function process(): void
    {
        $this->validate();
        $this->handle();
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    private function validate(): void
    {
        app(MarkdownFileValidator::class)
            ->withRules($this->scheme->config->rules())
            ->validate($this);
    }

    private function handle(): void
    {
        $this->scheme->config->handler()($this);
    }
}
