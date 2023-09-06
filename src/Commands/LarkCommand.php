<?php

namespace Carlcassar\Lark\Commands;

use Illuminate\Console\Command;

class LarkCommand extends Command
{
    public $signature = 'lark';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
