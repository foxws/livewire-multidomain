<?php

namespace Foxws\LivewireMultiDomain\Providers;

use Illuminate\Filesystem\Filesystem;
use Livewire\Commands\ComponentParser;
use Foxws\LivewireMultiDomain\Support\LivewireComponentsFinder;
use Foxws\MultiDomain\Providers\DomainServiceProvider;

class LivewireServiceProvider extends DomainServiceProvider
{
    public function register(): void
    {
        $this->registerComponentNamespaceDiscovery();
    }

    public function boot(): void
    {
        //
    }

    protected function registerComponentNamespaceDiscovery(): void
    {
        $defaultManifestPath = $this->app['livewire']->isRunningServerless()
            ? "/tmp/storage/bootstrap/cache/livewire-{$this->name()}-components.php"
            : $this->app->bootstrapPath("cache/livewire-{$this->name()}-components.php");

        $this->app->singleton(LivewireComponentsFinder::class, function () use ($defaultManifestPath) {
            return new LivewireComponentsFinder(
                files: new Filesystem,
                manifestPath: config('livewire.manifest_path') ?: $defaultManifestPath,
                prefix: $this->name(),
                path: ComponentParser::generatePathFromNamespace(
                    $this->namespace()
                ),
            );
        });
    }
}
