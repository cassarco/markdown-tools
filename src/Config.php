<?php

namespace Cassarco\MarkdownTools;

class Config
{
    private array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function path()
    {
        return $this->options['path'];
    }

    public function handler()
    {
        return $this->options['handler'];
    }

    public function frontMatterValidationRules()
    {
        return $this->options['validate-front-matter'];
    }

    public function frontMatterOrderValidationRule()
    {
        return $this->options['sort-front-matter'];
    }
}
