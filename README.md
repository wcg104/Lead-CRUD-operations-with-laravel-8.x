
Laravel CURD operation for lead
======



Installation
-----

Run a command for Laravel 9,

```
composer require wcg104/lead
```
To publish configurations,

```
php artisan vendor:publish --tag=lead
```


Usage
-----
To use CURD API operation for lead module.

```php
use Illuminate\Support\Facades\Route;

// To use api resource add this in route and change name of lead according to your requirement

Route::apiResource('lead', LeadController::class);
```
License
-----
This package is licensed under the `MIT` License. Please see the [License File] for more details.
