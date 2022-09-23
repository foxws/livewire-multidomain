<?php

namespace Foxws\LivewireMultidomain\Domains\Domain;

use Foxws\LivewireMultidomain\Domains\Domain;

class LivewireDomain extends Domain
{
    protected array $attributes = [];

    /** @var callable|null */
    protected $callableAttributes;

    public function name(string $name): self
    {
        $this->attributes(['name' => $name]);

        return $this;
    }

    public function namespace(string $namespace): self
    {
        $this->attributes(['namespace' => $namespace]);

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->attributes,
        ];
    }
}
