<?php

namespace Foxws\LivewireMultiDomain\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCommand extends Command
{
    public $signature = 'livewire-multidomain:clear';

    public $description = 'Clear the Livewire component cache.';

    public function handle(): void
    {
        $this->clearCache();

        $this->info('Livewire component cache cleared.');
    }

    protected function clearCache(): bool
    {
        return Cache::forget('livewire-multidomain');
    }
}
