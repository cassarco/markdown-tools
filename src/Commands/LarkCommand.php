<?php

namespace Cassarco\Lark\Commands;

use Cassarco\Lark\Facades\Lark;
use Illuminate\Console\Command;

class LarkCommand extends Command
{
    public $signature = 'lark:process';

    public $description = 'Process schemes in your lark config.';

    public function handle(): int
    {
        Lark::handle();

        $this->comment('Your Lark Schemes have all been processed successfully.');

        return self::SUCCESS;
    }
}
