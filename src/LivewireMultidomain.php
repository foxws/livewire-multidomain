<?php

namespace Foxws\LivewireMultidomain;

use Foxws\LivewireMultidomain\Domains\Domain;
use Foxws\LivewireMultidomain\Support\LivewireComponentsFinder;
use Illuminate\Support\Collection;

class LivewireMultidomain
{
    /** @var array<int, Domain> */
    protected array $domains = [];

    /** @param  array<int, Domain>  $domains */
    public function domains(array $domains): self
    {
        $this->domains = array_merge($this->domains, $domains);

        app(LivewireComponentsFinder::class)
            ->build($this->registeredDomains());

        return $this;
    }

    public function clearDomains(): self
    {
        $this->domains = [];

        return $this;
    }

    /** @return Collection<int, Domain> */
    public function registeredDomains(): Collection
    {
        return collect($this->domains);
    }
}
