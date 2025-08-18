<?php

namespace Cassarco\MarkdownTools;

use Cassarco\LeagueCommonmarkWikilinks\WikilinksExtension;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsConversionException;
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
    private Scheme $scheme;

    private string $pathname;

    private RenderedContentInterface $content;

    /**
     * @throws MarkdownToolsConversionException
     */
    final public function __construct(string $pathname, Scheme $scheme)
    {
        $this->pathname = $pathname;
        $this->scheme = $scheme;

        try {
            $this->generateRenderedContent();
        } catch (CommonMarkException $e) {
            throw new MarkdownToolsConversionException($e->getMessage());
        }
    }

    /**
     * @throws CommonMarkException
     */
    private function generateRenderedContent(): void
    {
        $environment = new Environment(config('markdown-tools.common-mark'));

        $environment->addExtension(new WikiLinksExtension);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new TableOfContentsExtension);
        $environment->addExtension(new HeadingPermalinkExtension);
        $environment->addExtension(new FrontMatterExtension(new FrontMatterParser));

        $this->content = (new MarkdownConverter($environment))->convert($this->markdown());
    }

    public function markdown(): string
    {
        return File::get($this->pathname);
    }

    public function pathname(): string
    {
        return $this->pathname;
    }

    public function html(): string
    {
        $crawler = new Crawler($this->htmlWithToc());
        $ulNodes = $crawler->filter('.table-of-contents');

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
        $ulNodes = $crawler->filter('.table-of-contents');

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
