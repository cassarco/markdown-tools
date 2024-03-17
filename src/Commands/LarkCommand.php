<?php

namespace Carlcassar\Lark\Commands;

use Carlcassar\Lark\Facades\Lark;
use Illuminate\Console\Command;

class LarkCommand extends Command
{
    public $signature = 'lark:process';

    public $description = 'Process schemes in your lark config.';

    public function handle(): int
    {
        Lark::handle();

        $this->comment('Your Lark Schemes have all been process successfully.');

        return self::SUCCESS;
    }
}
