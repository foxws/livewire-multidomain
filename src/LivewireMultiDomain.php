<?php

namespace Foxws\LivewireMultiDomain;

class LivewireMultiDomain
{
    public function __construct(
        protected LivewireMultiDomainRepository $repository,
    ) {
    }

    public function boot(): void
    {
        $this->repository->build();
    }
}
