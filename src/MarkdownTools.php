<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Exceptions\InvalidSchemeException;
use Cassarco\MarkdownTools\Exceptions\NoSchemesDefinedException;

class MarkdownTools
{
    private array $requiredKeys = [
        'path',
    ];

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
        $this->ensureThatEachSchemeHasTheNecessaryKeys();
    }

    /**
     * @throws NoSchemesDefinedException
     */
    private function ensureThatWeHaveAtLeastOneScheme(): void
    {
        if (empty(config('markdown-tools')['schemes'])) {
            throw new NoSchemesDefinedException();
        }
    }

    /**
     * @throws InvalidSchemeException
     */
    private function ensureThatEachSchemeHasTheNecessaryKeys(): void
    {
        foreach (config('markdown-tools')['schemes'] as $scheme) {
            foreach ($this->requiredKeys as $key) {
                if (! array_key_exists($key, $scheme)) {
                    throw new InvalidSchemeException("Every scheme must have a $key key");
                }
            }
        }
    }
}
