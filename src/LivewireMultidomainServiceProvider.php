<?php

namespace Foxws\LivewireMultidomain;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireMultidomainServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('livewire-multidomain')
            ->hasCommands(
                // CacheCommand::class,
                // ClearCommand::class,
            );
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(LivewireMultidomain::class, fn () => new LivewireMultidomain());
        $this->app->bind('livewire-multidomain', LivewireMultidomain::class);
    }
}
