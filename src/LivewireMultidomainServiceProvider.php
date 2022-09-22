<?php

namespace Foxws\LivewireMultidomain;

use Foxws\LivewireMultidomain\Commands\LivewireMultidomainCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireMultidomainServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('livewire-multidomain')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_livewire-multidomain_table')
            ->hasCommand(LivewireMultidomainCommand::class);
    }
}
