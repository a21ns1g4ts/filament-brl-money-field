<?php

namespace A21ns1g4ts\FilamentBrlMoneyField\Commands;

use Illuminate\Console\Command;

class FilamentBrlMoneyFieldCommand extends Command
{
    public $signature = 'filament-brl-money-field';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
