<?php

namespace Cassarco\MarkdownTools\Commands;

use Cassarco\MarkdownTools\Facades\MarkdownTools;
use Illuminate\Console\Command;

class MarkdownToolsCommand extends Command
{
    public $signature = 'markdown-tools:process';

    public $description = 'Process the schemes defined in your configuration file.';

    public function handle(): int
    {
        MarkdownTools::process();

        $this->comment('Your schemes have all been processed successfully.');

        return self::SUCCESS;
    }
}
