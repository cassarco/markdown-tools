<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MarkdownToolsMarkdownFileValidator
{
    private MarkdownFile $file;

    private array $rules;

    private MarkdownToolsFrontMatterKeyOrder $order;

    public function __construct(MarkdownFile $file, array $validation)
    {
        $this->file = $file;
        $this->rules = $validation['rules'] ?? [];
        $this->order = $validation['order'] ?? MarkdownToolsFrontMatterKeyOrder::None;
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
        $validator = Validator::make($this->file->frontMatter(), $this->rules);

        if ($validator->fails()) {
            throw new MarkdownToolsValidationException(
                "{$this->file->filename()}: ".(new ValidationException($validator))->getMessage()
            );
        }
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    private function validateOrder(): void
    {
        if (empty($this->order)) {
            return;
        }

        if ($this->order == MarkdownToolsFrontMatterKeyOrder::RuleOrder) {
            if (array_keys($this->file->frontMatter()) !== array_keys($this->rules)) {
                throw new MarkdownToolsValidationException(
                    "{$this->file->filename()}: Keys are not in the correct order: ".implode(', ',
                        $this->rules)
                );
            }
        }
    }
}
