<?php

namespace Foxws\LivewireMultidomain\Support;

use Exception;
use Foxws\LivewireMultidomain\Domains\Domain\LivewireDomain;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Commands\ComponentParser;
use Livewire\Component;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class LivewireComponentsFinder
{
    public function build(Collection $domains): void
    {
        $manifest = collect($this->getManifest());

        $manifest = $manifest->merge(
            $domains->flatMap(fn (LivewireDomain $domain) => $this
                ->getClassNames($domain->namespace)
                ->mapWithKeys(function ($class) use ($domain) {
                    $alias = $this->getComponentAlias(
                        $domain->namespace,
                        $domain->name,
                        $class
                    );

                    return [$alias => $class];
                })
            )
        );

        $this->write($manifest->toArray());
    }

    protected function find($alias): ?array
    {
        $manifest = $this->getManifest();

        return $manifest[$alias] ?? $manifest["{$alias}.index"] ?? null;
    }

    protected function getManifest(): mixed
    {
        $manifestPath = $this->getManifestPath();

        throw_if(! file_exists($manifestPath), FileNotFoundException::class);

        return File::getRequire($manifestPath);
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

    protected function getManifestPath(): string
    {
        // We will generate a manifest file so we don't have to do the lookup every time.
        $defaultManifestPath = app('livewire')->isRunningServerless()
            ? '/tmp/storage/bootstrap/cache/livewire-components.php'
            : app()->bootstrapPath('cache/livewire-components.php');

        return config('livewire.manifest_path') ?: $defaultManifestPath;
    }

    protected function write(array $manifest): void
    {
        $manifestPath = $this->getManifestPath();

        if (! is_writable(dirname($manifestPath))) {
            throw new Exception('The '.dirname($manifestPath).' directory must be present and writable.');
        }

        File::put($manifestPath, '<?php return '.var_export($manifest, true).';', true);
    }
}
