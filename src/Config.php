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

    public function rules()
    {
        return $this->options['rules'];
    }

    public function handler()
    {
        return $this->options['handler'];
    }
}
