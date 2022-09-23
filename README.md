# Use Livewire in a multidomain environment

[![Latest Version on Packagist](https://img.shields.io/packagist/v/foxws/livewire-multidomain.svg?style=flat-square)](https://packagist.org/packages/foxws/livewire-multidomain)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/foxws/livewire-multidomain/run-tests?label=tests)](https://github.com/foxws/livewire-multidomain/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/foxws/livewire-multidomain/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/foxws/livewire-multidomain/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/foxws/livewire-multidomain.svg?style=flat-square)](https://packagist.org/packages/foxws/livewire-multidomain)

## Description

This package allows a single Livewire application to work with multiple domains/tenants.

It is intended to complement a multi-tenancy package such as [spatie/laravel-multitenancy](https://github.com/spatie/laravel-multitenancy), [archtechx/tenancy](https://github.com/archtechx/tenancy), etc.

## Installation

You can install the package via composer:

```bash
composer require foxws/livewire-multidomain
```

## Usage

Update `config/livewire.php`:

```php
'class_namespace' => 'App',
```

Regenerate the Livewire component auto-discovery manifest:

```bash
php artisan livewire:discover
```

Create a service provider, e.g. `LivewireServiceProvider`, and [register](https://laravel.com/docs/9.x/providers#registering-providers) the provider:

```php
use Foxws\LivewireMultidomain\Domains\Domain\LivewireDomain;
use Foxws\LivewireMultidomain\Facades\LivewireMultidomain;
use Illuminate\Support\ServiceProvider;

class LivewireServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        LivewireMultidomain::domains([
            LivewireDomain::new()
                ->name('foo')
                ->namespace('App\\Domain\\Foo\Resources\\Components'),

            LivewireDomain::new()
                ->name('bar')
                ->namespace('App\\Domain\\Bar\Resources\\Components'),
        ]);
    }
}
```

To render a component:

```php
// @livewire blade directive
@livewire('foo::component-name')
@livewire('bar::component-name')

// <livewire: tag syntax
<livewire:foo::component-name />
<livewire:bar::component-name />
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

- [foxws](https://github.com/foxws)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
