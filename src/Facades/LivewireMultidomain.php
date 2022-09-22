<?php

namespace Foxws\LivewireMultidomain\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\LivewireMultidomain\LivewireMultidomain
 */
class LivewireMultidomain extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Foxws\LivewireMultidomain\LivewireMultidomain::class;
    }
}
