<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Component caching
    |--------------------------------------------------------------------------
    |
    | This defines the Livewire component caching.
    |
    */

    'cache_enabled' => env('LIVEWIRE_MULTIDOMAIN_CACHE_ENABLED', false),

    'cache_lifetime' => env('LIVEWIRE_MULTIDOMAIN_CACHE_LIFETIME', 60 * 60 * 24 * 7),
];
