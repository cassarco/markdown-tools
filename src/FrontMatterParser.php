<?php

declare(strict_types=1);

namespace Cassarco\MarkdownTools;

use Config;
use League\CommonMark\Exception\MissingDependencyException;
use League\CommonMark\Extension\FrontMatter\Data\FrontMatterDataParserInterface;
use League\CommonMark\Extension\FrontMatter\Exception\InvalidFrontMatterException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

use function class_exists;

class FrontMatterParser implements FrontMatterDataParserInterface
{
    public function parse(string $frontMatter)
    {
        if (! class_exists(Yaml::class)) {
            throw new MissingDependencyException('Failed to parse yaml: "symfony/yaml" library is missing');
        }

        try {
            return Yaml::parse($frontMatter, Config::get('markdown-tools.common-mark.front-matter.yaml-parse-flags'));
        } catch (ParseException $ex) {
            throw InvalidFrontMatterException::wrap($ex);
        }
    }
}
