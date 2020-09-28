# Bagisto FeDex
This extension used for calculating shipping rate with the FedEx services.

## Requirements
- [Bagisto](https://github.com/bagisto/bagisto)
- jeremy-dunn/php-fedex-api-wrapper (https://packagist.org/packages/jeremy-dunn/php-fedex-api-wrapper)

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
7. Go to `https://<your-site>/admin/configuration/sales/shipping` and add shipping address.

Your customers are now able to select the new shipping method.

## Example data

### FedEx key
- Account ID: 510087240
- Meter Number: 114001500
- Key: aRUu7CcsdSAn9NgB
- Password: mjz590b4Slv0vJEFXeWKnkiv8

### Shipper address
- Street Address: 8383 Bowman Dr. Los Angeles
- State: CA
- Zip: 90022
- City: Los Angeles
- Country: US

### Recipient address
- Street Address: 10 Fed Ex Pkwy
- State: VA
- Zip: 20171
- City: Herndon
- Country: US
