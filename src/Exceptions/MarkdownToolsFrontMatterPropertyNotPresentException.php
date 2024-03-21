<?php

namespace Cassarco\MarkdownTools\Exceptions;

class MarkdownToolsFrontMatterPropertyNotPresentException extends MarkdownToolsValidationException
{
    public function __toString(): string
    {
        return __CLASS__.": {'Front Matter property not present'}\n";
    }
}
