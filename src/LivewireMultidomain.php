<?php

namespace Foxws\LivewireMultidomain;

use Foxws\LivewireMultidomain\Components\Component;
use Foxws\LivewireMultidomain\Support\LivewireComponentsFinder;
use Illuminate\Support\Collection;

class LivewireMultidomain
{
    /** @var array<int, Component> */
    protected array $components = [];

    /** @param array<int, Component> $components */
    public function components(array $components): self
    {
        $this->components = array_merge($this->components, $components);

        (new LivewireComponentsFinder())
            ->build($this->registeredComponents());

        return $this;
    }

    public function clearComponents(): self
    {
        $this->components = [];

        return $this;
    }

    /** @return Collection<int, Component> */
    public function registeredComponents(): Collection
    {
        return collect($this->components);
    }
}
