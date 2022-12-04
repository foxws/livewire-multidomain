# Use Livewire in a multidomain environment

[![Latest Version on Packagist](https://img.shields.io/packagist/v/foxws/livewire-multidomain.svg?style=flat-square)](https://packagist.org/packages/foxws/livewire-multidomain)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/foxws/livewire-multidomain/run-tests?label=tests)](https://github.com/foxws/livewire-multidomain/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/foxws/livewire-multidomain/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/foxws/livewire-multidomain/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/foxws/livewire-multidomain.svg?style=flat-square)](https://packagist.org/packages/foxws/livewire-multidomain)

## Description

This package allows a single Livewire application to work with multiple domains/tenants.

It is intended to complement a multi-tenancy package such as [spatie/laravel-multitenancy](https://github.com/spatie/laravel-multitenancy) (tested and supported), [archtechx/tenancy](https://github.com/archtechx/tenancy), etc.

> **NOTE:** This package requires [foxws/laravel-multidomain](https://github.com/foxws/laravel-multidomain).

> **TIP:** See [foxws/laravel-multidomain-demo](https://github.com/foxws/laravel-multidomain-demo) for a boilerplate.

## Installation

You can install the package via composer:

```bash
composer require foxws/livewire-multidomain
```

Update `config/livewire.php`:

```php
'class_namespace' => 'App',
```

Setup a working multidomain environment by installing and configuring [foxws/laravel-multidomain](https://github.com/foxws/laravel-multidomain).

### Laravel Multitenancy

When using Spatie's [laravel-multitenancy](https://github.com/spatie/laravel-multitenancy), one may want to use the following task to auto register service providers for each domain:

> **NOTE:** Please see [documentation](https://spatie.be/docs/laravel-multitenancy/v2/using-tasks-to-prepare-the-environment/creating-your-own-task) for details.

```php
<?php

namespace App\Core\Support\Multitenancy\Tasks;

use Foxws\LivewireMultiDomain\Facades\LivewireMultiDomain;
use Foxws\MultiDomain\Facades\MultiDomain;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class SwitchDomainTask implements SwitchTenantTask
{
    public function makeCurrent(Tenant $tenant): void
    {
        MultiDomain::initialize($tenant->domain);
        LivewireMultiDomain::initialize($tenant->domain);
    }

    public function forgetCurrent(): void
    {
    }
}
```

## Usage

Regenerate the Livewire component auto-discovery manifest:

```bash
php artisan livewire:discover
```

To render a component with domain using name `Foo`:

```php
// @livewire blade directive
@livewire('foo.component-name')

// <livewire: tag syntax
<livewire:foo.component-name />
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Livewire](https://github.com/livewire)
- [Spatie](https://github.com/spatie)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
