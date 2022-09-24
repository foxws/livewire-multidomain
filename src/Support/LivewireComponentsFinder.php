<?php

namespace Foxws\LivewireMultiDomain\Support;

use Foxws\MultiDomain\Domains\Domain\MultiDomain;
use Foxws\MultiDomain\MultiDomainRepository;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class LivewireComponentsFinder
{
    public function __construct(
        protected CacheRepository $cache,
        protected ConfigRepository $config,
        protected MultiDomainRepository $repository,
        protected Filesystem $files,
    ) {
    }

    public function manifest(): array
    {
        if (! $this->config->get('livewire-multidomain.cache_enabled')) {
            return $this->scan();
        }

        return $this->cached();
    }

    protected function scan(): array
    {
        $domains = collect($this->repository->all());

        $manifest = $domains->flatMap(
            fn (MultiDomain $domain) => $this
                ->classNames($domain->name)
                ->mapWithKeys(function ($class) use ($domain) {
                    $key = $this->componentAlias($domain->name, $class);

                    return [$key => $class];
                })
        );

        return $manifest->toArray();
    }

    protected function cached(): array
    {
        $ttl = $this->config->get('livewire-multidomain.cache_lifetime');

        return $this->cache->remember('livewire-multidomain', $ttl, function () {
            return $this->scan();
        });
    }

    protected function componentAlias(string $name, string $class): string
    {
        $namespace = collect(explode('.', str_replace(['/', '\\'], '.', $this->namespace($name))))
            ->map([Str::class, 'kebab'])
            ->implode('.');

        $fullName = collect(explode('.', str_replace(['/', '\\'], '.', $class)))
            ->map([Str::class, 'kebab'])
            ->implode('.');

        if (str($fullName)->startsWith($namespace)) {
            return strtolower($name).'::'.(string) str($fullName)->substr(strlen($namespace) + 1);
        }

        return $fullName;
    }

    protected function classNames(string $name): Collection
    {
        $path = namespace_path($this->namespace($name));

        if (! $this->files->exists($path)) {
            return collect();
        }

        return collect($this->files->allFiles($path))
            ->map(function (SplFileInfo $file) {
                return app()->getNamespace().
                    str($file->getPathname())
                        ->after(app_path().'/')
                        ->replace(['/', '.php'], ['\\', ''])->__toString();
            })
            ->filter(function (string $class) {
                return is_subclass_of($class, Component::class) &&
                    ! (new ReflectionClass($class))->isAbstract();
            });
    }

    protected function namespace(string $name): string
    {
        $namespace = $this->config->get('multidomain.namespace');

        return "{$namespace}\\{$name}\\Resources\\Components";
    }
}
