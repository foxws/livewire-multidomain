<?php

namespace Foxws\LivewireMultiDomain;

use Foxws\LivewireMultiDomain\Commands\ClearCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireMultiDomainServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('livewire-multidomain')
            ->hasConfigFile()
            ->hasCommands(
                ClearCommand::class,
            );
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(LivewireMultiDomain::class, function ($app) {
            return new LivewireMultiDomain($app->make(LivewireMultiDomainRepository::class));
        });

        $this->app->bind('livewire-multidomain', LivewireMultiDomain::class);
    }

    public function packageBooted(): void
    {
        $this->app->make(LivewireMultiDomain::class)->boot();
    }
}
