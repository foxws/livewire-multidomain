<?php

namespace Foxws\LivewireMultidomain\Support;

use Foxws\LivewireMultidomain\Domains\Domain\LivewireDomain;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Commands\ComponentParser;
use Livewire\Component;
use Livewire\LivewireManager;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class LivewireComponentsFinder
{
    public function build(Collection $domains): void
    {
        $manifest = $domains->flatMap(
            fn (LivewireDomain $domain) => $this
                ->getClassNames($domain->namespace)
                ->mapWithKeys(function ($class) use ($domain) {
                    $alias = $this->getComponentAlias(
                        $domain->namespace,
                        $domain->name,
                        $class
                    );

                    return [$alias => $class];
                })
        );

        $this->register($manifest);
    }

    protected function register(Collection $manifest): void
    {
        $manifest->each(
            fn (string $class, string $alias) => app(LivewireManager::class)->component($alias, $class)
        );
    }

    protected function getNamespacePath(string $path): string
    {
        return ComponentParser::generatePathFromNamespace($path);
    }

    protected function getComponentAlias(string $namespace, string $name, string $class): string
    {
        $namespace = collect(explode('.', str_replace(['/', '\\'], '.', $namespace)))
            ->map([Str::class, 'kebab'])
            ->implode('.');

        $fullName = collect(explode('.', str_replace(['/', '\\'], '.', $class)))
            ->map([Str::class, 'kebab'])
            ->implode('.');

        if (str($fullName)->startsWith($namespace)) {
            return "{$name}::".(string) str($fullName)->substr(strlen($namespace) + 1);
        }

        return "{$name}::{$fullName}";
    }

    protected function getClassNames(string $namespace): Collection
    {
        $path = $this->getNamespacePath($namespace);

        if (! File::exists($path)) {
            return collect();
        }

        return collect(File::allFiles($path))
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
}
