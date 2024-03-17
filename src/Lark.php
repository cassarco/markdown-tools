<?php

namespace Carlcassar\Lark;

use Illuminate\Support\Collection;

class Lark
{
    protected LarkConfig $config;

    public function __construct()
    {
        $this->config = new LarkConfig();
    }

    public function handle(): void
    {
        $this->config->schemes()
            ->each(fn(LarkScheme $scheme) => $scheme->handle());
    }

    public function schemes(): Collection
    {
        return $this->config->schemes();
    }
}
