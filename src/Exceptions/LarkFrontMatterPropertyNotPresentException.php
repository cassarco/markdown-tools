<?php

namespace Carlcassar\Lark\Exceptions;

class LarkFrontMatterPropertyNotPresentException extends LarkValidationException
{
    public function __toString()
    {
        return __CLASS__.": {'Front Matter property not present'}\n";
    }
}
