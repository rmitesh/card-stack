<?php

namespace Rmitesh\CardStack\Commands;

use Illuminate\Console\Command;

class CardStackCommand extends Command
{
    public $signature = 'card-stack';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
