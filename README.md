# Bagisto FeDex
This extension used for calculating shipping rate with the FeDex services.

## Requirements
- [Bagisto](https://github.com/bagisto/bagisto)

## Installation

### Install with composer
1. Run the following command
```php
composer require hunghbm/bagisto-fedex
```
2. Open config/app.php and add **Hunghbm\FedEx\Providers\FedExServiceProvider::class**.
3. Run the following command
```php
composer dump-autoload
```
4. Go to `https://<your-site>/admin/configuration/sales/carriers`.
5. Make sure that **Marketplace FedEx** is active and press save.

### Install with package folder
1. Unzip all the files to **packages/GGPHP/Shipping**.
2. Open `config/app.php` and add **GGPHP\Shipping\Providers\ShippingServiceProvider::class**.
3. Open `composer.json` of root project and add **GGPHP\Shipping\Providers\ShippingServiceProvider::class**.
4. Run the following command
```php
composer dump-autoload
```
5. Go to `https://<your-site>/admin/configuration/sales/carriers`.
6. Make sure that **Marketplace FedEx** is active and press save.

Your customers are now able to select the new shipping method.
