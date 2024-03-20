<?php

namespace Cassarco\MarkdownTools\Exceptions;

class MarkdownToolsFrontMatterPropertyNotPresentException extends MarkdownToolsValidationException
{
    public function __toString()
    {
        return __CLASS__.": {'Front Matter property not present'}\n";
    }
}
