<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Contracts\MarkdownFileHandler;
use Cassarco\MarkdownTools\Contracts\MarkdownFileRules;
use Cassarco\MarkdownTools\Exceptions\InvalidConfigException;

class Config
{
    private array $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function path(): string
    {
        return $this->options['path'];
    }

    public function rules(): array
    {
        $rules = $this->options['rules'] ?? null;

        if ($rules === null) {
            return [];
        }

        if (is_array($rules)) {
            return $rules;
        }

        if (is_string($rules)) {
            if (! class_exists($rules)) {
                throw new InvalidConfigException(
                    "Rules class [{$rules}] does not exist. Run: php artisan vendor:publish --tag=markdown-tools-actions"
                );
            }

            if (! is_a($rules, MarkdownFileRules::class, true)) {
                throw new InvalidConfigException(
                    "Rules class [{$rules}] must implement ".MarkdownFileRules::class
                );
            }

            return app($rules)();
        }

        return [];
    }

    public function handler(): MarkdownFileHandler
    {
        $handler = $this->options['handler'] ?? null;

        if ($handler === null) {
            throw new InvalidConfigException(
                'Handler class is required. Run: php artisan vendor:publish --tag=markdown-tools-actions'
            );
        }

        if (is_string($handler)) {
            if (! class_exists($handler)) {
                throw new InvalidConfigException(
                    "Handler class [{$handler}] does not exist. Run: php artisan vendor:publish --tag=markdown-tools-actions"
                );
            }

            if (! is_a($handler, MarkdownFileHandler::class, true)) {
                throw new InvalidConfigException(
                    "Handler class [{$handler}] must implement ".MarkdownFileHandler::class
                );
            }

            return app($handler);
        }

        throw new InvalidConfigException(
            'Handler must be a class name implementing '.MarkdownFileHandler::class
        );
    }
}
