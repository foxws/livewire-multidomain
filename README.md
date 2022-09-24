# Use Livewire in a multidomain environment

[![Latest Version on Packagist](https://img.shields.io/packagist/v/foxws/livewire-multidomain.svg?style=flat-square)](https://packagist.org/packages/foxws/livewire-multidomain)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/foxws/livewire-multidomain/run-tests?label=tests)](https://github.com/foxws/livewire-multidomain/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/foxws/livewire-multidomain/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/foxws/livewire-multidomain/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/foxws/livewire-multidomain.svg?style=flat-square)](https://packagist.org/packages/foxws/livewire-multidomain)

## Description

This package allows a single Livewire application to work with multiple domains/tenants.

It is intended to complement a multi-tenancy package such as [spatie/laravel-multitenancy](https://github.com/spatie/laravel-multitenancy) (tested), [archtechx/tenancy](https://github.com/archtechx/tenancy), etc.

> **NOTE:** This package requires [foxws/laravel-multidomain](https://github.com/foxws/laravel-multidomain).

## Installation

You can install the package via composer:

```bash
composer require foxws/livewire-multidomain
```

Setup a working multidomain environment by installing and configuring [foxws/laravel-multidomain](https://github.com/foxws/laravel-multidomain).

## Usage

Update `config/livewire.php`:

```php
'class_namespace' => 'App',
```

Regenerate the Livewire component auto-discovery manifest:

```bash
php artisan livewire:discover
```

To render a component with domain `foo` or `bar`:

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
- [Livewire](https://github.com/livewire)
- [Spatie](https://github.com/spatie)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
