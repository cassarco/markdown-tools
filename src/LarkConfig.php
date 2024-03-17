<?php

namespace Carlcassar\Lark;

use Carlcassar\Lark\Exceptions\LarkInvalidSchemeException;
use Carlcassar\Lark\Exceptions\LarkNoSchemesDefinedException;
use Illuminate\Support\Collection;

class LarkConfig
{
    private array $config;

    private array $requiredKeys = [
        'path'
    ];

    private Collection $schemes;

    /**
     * @throws LarkNoSchemesDefinedException|LarkInvalidSchemeException
     */
    public function __construct()
    {
        $this->config = config('lark');

        $this->validateSchemes();

        $this->schemes = $this->makeSchemes();
    }

    /**
     * Verify that each scheme array in the config has a valid structure.
     *
     * @throws LarkNoSchemesDefinedException
     * @throws LarkInvalidSchemeException
     */
    private function validateSchemes(): void
    {
        if (empty($this->config['schemes'])) {
            throw new LarkNoSchemesDefinedException;
        }

        foreach ($this->config['schemes'] as $scheme) {
            foreach ($this->requiredKeys as $key) {
                if (!key_exists($key, $scheme)) {
                    throw new LarkInvalidSchemeException("Every scheme must have a {$key} key");
                }
            }
        }
    }

    /**
     * Generate the lark schemes from the lark configuration file.
     */
    private function makeSchemes(): Collection
    {
        return collect($this->config['schemes'])->map(function ($scheme) {
            $larkScheme = new LarkScheme(path: $scheme['path']);

            if (key_exists('validation', $scheme)) {
                $larkScheme->withValidation($scheme['validation']);
            }

            if (key_exists('handler', $scheme)) {
                $larkScheme->withHandler($scheme['handler']);
            }

            return $larkScheme;
        });
    }

    /**
     * Get all lark schemes from the lark configuration file.
     */
    public function schemes()
    {
        return $this->schemes;
    }
}
