<?php

namespace Foxws\LivewireMultiDomain;

use Foxws\LivewireMultiDomain\Providers\LivewireServiceProvider;
use Foxws\MultiDomain\MultiDomain;

class LivewireMultiDomain extends MultiDomain
{
    public function initialize(string $domain): void
    {
        $domain = $this->findByDomain($domain);

        $provider = $this->app->make(LivewireServiceProvider::class, compact('domain'));

        $provider->register();
        $provider->boot();
    }
}
