<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Enums\FrontMatterKeyOrder;
use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MarkdownFileValidator
{
    private MarkdownFile $file;

    private Config $config;

    public function __construct(MarkdownFile $file, Config $config)
    {
        $this->file = $file;
        $this->config = $config;
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    public function validate(): void
    {
        $this->validateKeys();
        $this->validateOrder();
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    private function validateKeys(): void
    {
        $validator = Validator::make($this->file->frontMatter(), $this->config->frontMatterValidationRules());

        if ($validator->fails()) {
            throw new MarkdownToolsValidationException(
                "{$this->file->filename}: ".(new ValidationException($validator))->getMessage()
            );
        }
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    private function validateOrder(): void
    {
        if (empty($this->config->frontMatterOrderValidationRule())) {
            return;
        }

        if ($this->config->frontMatterOrderValidationRule() == FrontMatterKeyOrder::ValidationOrder) {
            if (array_keys($this->file->frontMatter()) !== array_keys($this->config->frontMatterValidationRules())) {
                throw new MarkdownToolsValidationException(
                    "{$this->file->filename}: Keys are not in the correct order: ".implode(', ',
                        $this->config->frontMatterValidationRules())
                );
            }
        }
    }
}
