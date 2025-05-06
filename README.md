# Filament BRL Field Money

![Art](./art.png)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/a21ns1g4ts/filament-brl-money-field.svg?style=flat-square)](https://packagist.org/packages/a21ns1g4ts/filament-brl-money-field)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/a21ns1g4ts/filament-brl-money-field/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/a21ns1g4ts/filament-brl-money-field/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/a21ns1g4ts/filament-brl-money-field/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/a21ns1g4ts/filament-brl-money-field/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/a21ns1g4ts/filament-brl-money-field.svg?style=flat-square)](https://packagist.org/packages/a21ns1g4ts/filament-brl-money-field)


## Installation

You can install the package via composer:

```bash
composer require a21ns1g4ts/filament-brl-money-field
```

## Usage
```php
use A21ns1g4ts\FilamentBrlMoneyField\BrlMoneyInput;

BrlMoneyInput::make('price')
    ->label('Preço')
    ->columnSpan(1)
                                  
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [a21ns1g4ts](https://github.com/a21ns1g4ts)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
