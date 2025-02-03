<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Exceptions\InvalidSchemeException;
use Cassarco\MarkdownTools\Exceptions\NoSchemesDefinedException;

class MarkdownTools
{
    /**
     * @throws InvalidSchemeException
     * @throws NoSchemesDefinedException
     */
    public function process(): void
    {
        $this->validateConfiguration();

        collect(config('markdown-tools')['schemes'])
            ->map(fn ($options) => new Scheme(new Config($options)))
            ->each(fn ($scheme) => $scheme->process());
    }

    /**
     * @throws InvalidSchemeException
     * @throws NoSchemesDefinedException
     */
    private function validateConfiguration(): void
    {
        $this->ensureThatWeHaveAtLeastOneScheme();
        $this->ensureThatEachSchemeHasAPath();
    }

    /**
     * @throws NoSchemesDefinedException
     */
    private function ensureThatWeHaveAtLeastOneScheme(): void
    {
        if (empty(config('markdown-tools')['schemes'])) {
            throw new NoSchemesDefinedException;
        }
    }

    /**
     * @throws InvalidSchemeException
     */
    private function ensureThatEachSchemeHasAPath(): void
    {
        foreach (config('markdown-tools')['schemes'] as $name => $scheme) {
            if (! array_key_exists('path', $scheme)) {
                throw new InvalidSchemeException("Scheme '$name' must have a path");
            }

            if (empty($scheme['path'])) {
                throw new InvalidSchemeException("The path in $name must not be empty");
            }
        }
    }
}
