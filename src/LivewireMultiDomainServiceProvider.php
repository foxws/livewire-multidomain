<?php

namespace Foxws\LivewireMultiDomain;

use Illuminate\Foundation\Application;
use Livewire\LivewireManager;
use Foxws\LivewireMultiDomain\Providers\LivewireServiceProvider;
use Foxws\LivewireMultiDomain\Support\LivewireManager as Handler;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireMultiDomainServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('livewire-multidomain');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(LivewireMultiDomain::class);
        $this->app->alias(LivewireMultiDomain::class, 'livewire-multidomain');

        $this->app->singleton(LivewireServiceProvider::class, fn (Application $app, array $parameters) => new LivewireServiceProvider($app, $parameters));
        $this->app->singleton(LivewireManager::class, Handler::class);
    }
}
