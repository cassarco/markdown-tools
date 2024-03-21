<?php

namespace Cassarco\MarkdownTools\Exceptions;

class NoSchemesDefinedException extends MarkdownToolsException
{
    public function __toString(): string
    {
        return __CLASS__.": {'You must declare at least one import configuration in config/markdown-tools.php'}\n";
    }
}
