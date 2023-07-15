<?php

namespace Rmitesh\CardStack\Commands;

use Illuminate\Console\Command;

class CardStackCommand extends Command
{
    public $signature = 'init:card-stack';

    public $description = 'Initialize card stack';

    public function handle(): int
    {
        $this->call('make:filament-resource CardResource --simple');

        
        return self::SUCCESS;
    }
}
