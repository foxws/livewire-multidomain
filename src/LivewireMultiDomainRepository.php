<?php

namespace Foxws\LivewireMultiDomain;

use Foxws\LivewireMultiDomain\Support\LivewireComponentsFinder;
use Illuminate\Foundation\Application;
use Livewire\LivewireManager;

class LivewireMultiDomainRepository
{
    public function __construct(
        protected Application $app,
    ) {
    }

    public function build(): void
    {
        foreach ($this->all() as $key => $class) {
            app(LivewireManager::class)->component($key, $class);
        }
    }

    public function all(): array
    {
        return $this->app->make(LivewireComponentsFinder::class)->manifest();
    }
}
