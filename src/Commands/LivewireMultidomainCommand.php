<?php

namespace Foxws\LivewireMultidomain\Commands;

use Illuminate\Console\Command;

class LivewireMultidomainCommand extends Command
{
    public $signature = 'livewire-multidomain';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
