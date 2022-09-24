<?php

namespace Foxws\LivewireMultiDomain\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\LivewireMultiDomain\LivewireMultiDomain
 */
class LivewireMultiDomain extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Foxws\LivewireMultiDomain\LivewireMultiDomain::class;
    }
}
