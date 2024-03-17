<?php

namespace Cassarco\Lark;

use Cassarco\Lark\Exceptions\LarkValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LarkMarkdownFileValidator
{
    private MarkdownFile $file;

    private array $rules;

    private LarkFrontMatterKeyOrder $order;

    public function __construct(MarkdownFile $file, array $validation)
    {
        $this->file = $file;
        $this->rules = $validation['rules'] ?? [];
        $this->order = $validation['order'] ?? LarkFrontMatterKeyOrder::None;
    }

    /**
     * @throws LarkValidationException
     */
    public function validate(): void
    {
        $this->validateKeys();
        $this->validateOrder();
    }

    /**
     * @throws LarkValidationException
     */
    private function validateKeys(): void
    {
        $validator = Validator::make($this->file->frontMatter(), $this->rules);

        if ($validator->fails()) {
            throw new LarkValidationException(
                "{$this->file->filename()}: ".(new ValidationException($validator))->getMessage()
            );
        }
    }

    /**
     * @throws LarkValidationException
     */
    private function validateOrder(): void
    {
        if (empty($this->order)) {
            return;
        }

        if ($this->order == LarkFrontMatterKeyOrder::RuleOrder) {
            if (array_keys($this->file->frontMatter()) !== array_keys($this->rules)) {
                throw new LarkValidationException(
                    "{$this->file->filename()}: Keys are not in the correct order: ".implode(', ',
                        $this->rules)
                );
            }
        }
    }
}
