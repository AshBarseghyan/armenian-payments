# A simple package for Armenian payments

> **⚠️ Warning:**  
> This package is currently under development. Features and functionality may change, and the package may not be fully
> stable for production use. Please use with caution and report any issues to the repository.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/abn/armenian-payments.svg?style=flat-square)](https://packagist.org/packages/abn/armenian-payments)
[![Total Downloads](https://img.shields.io/packagist/dt/abn/armenian-payments.svg?style=flat-square)](https://packagist.org/packages/abn/armenian-payments)

Use this package to integrate Armenian payment gateways in your Laravel application.

## Installation

You can install the package via composer:

```bash
composer require abn/armenian-payments
```

## Publish assets

```php
php artisan vendor:publish --tag=public

```

### Usage Instructions

#### AmeriaBank Integration

To integrate AmeriaBank payments using the `abn/armenian-payments` package, follow the steps below:

1. **Add AmeriaBank Credentials**  
   Add the AmeriaBank credentials to the `.env` file.

   ```env
   AMERIA_CLIENT_ID=your-client-id
   AMERIA_USERNAME=your-username
   AMERIA_PASSWORD=your-password
   ```
2. **Create a New Instance**  
   Initialize the payment class with the required parameters such as amount, currency, and bank.

   ```php
   use Abn\ArmenianPayments\ArmenianPayments;

   // Create a new instance with AmeriaBank credentials
   $armenianPayments = new ArmenianPayments(100, 'AMD', 'ameria');

   // Initiate a payment
   $payment = $armenianPayments->makePayment();

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ashbarseghyan99@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
