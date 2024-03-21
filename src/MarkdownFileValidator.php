<?php

namespace Cassarco\MarkdownTools;

use Cassarco\MarkdownTools\Exceptions\MarkdownToolsValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MarkdownFileValidator
{
    private array $rules;

    public function withRules(array $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * @throws MarkdownToolsValidationException
     */
    public function validate(MarkdownFile $file): void
    {
        $validator = Validator::make($file->frontMatter(), $this->rules);

        $message = app(ValidationException::class, compact('validator'))->getMessage();

        if ($validator->fails()) {
            throw new MarkdownToolsValidationException(
                "$file->filename: $message"
            );
        }
    }
}
