<?php

namespace Carlcassar\Lark\Exceptions;

class LarkNoSchemesDefinedException extends LarkException
{
    public function __toString(): string
    {
        return __CLASS__.": {'You must declare at least one import configuration in config/lark.php'}\n";
    }
}
