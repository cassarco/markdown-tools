<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Exceptions\MarkdownToolsInvalidSchemeException;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsNoSchemesDefinedException;
use Illuminate\Support\Collection;

class MarkdownToolsConfig
{
    private array $config;

    private array $requiredKeys = [
        'path',
    ];

    private Collection $schemes;

    /**
     * @throws MarkdownToolsNoSchemesDefinedException|MarkdownToolsInvalidSchemeException
     */
    public function __construct()
    {
        $this->config = config('markdown-tools');

        $this->validateSchemes();

        $this->schemes = $this->makeSchemes();
    }

    /**
     * Verify that each scheme array in the config has a valid structure.
     *
     * @throws MarkdownToolsNoSchemesDefinedException
     * @throws MarkdownToolsInvalidSchemeException
     */
    private function validateSchemes(): void
    {
        if (empty($this->config['schemes'])) {
            throw new MarkdownToolsNoSchemesDefinedException;
        }

        foreach ($this->config['schemes'] as $scheme) {
            foreach ($this->requiredKeys as $key) {
                if (! array_key_exists($key, $scheme)) {
                    throw new MarkdownToolsInvalidSchemeException("Every scheme must have a {$key} key");
                }
            }
        }
    }

    /**
     * Generate the markdown-tools schemes from the markdown-tools configuration file.
     */
    private function makeSchemes(): Collection
    {
        return collect($this->config['schemes'])->map(function ($scheme) {
            $markdown-toolsScheme = new MarkdownToolsScheme(path: $scheme['path']);

            if (array_key_exists('validation', $scheme)) {
                $markdown-toolsScheme->withValidation($scheme['validation']);
            }

            if (array_key_exists('handler', $scheme)) {
                $markdown-toolsScheme->withHandler($scheme['handler']);
            }

            return $markdown-toolsScheme;
        });
    }

    /**
     * Get all markdown-tools schemes from the markdown-tools configuration file.
     */
    public function schemes()
    {
        return $this->schemes;
    }
}
