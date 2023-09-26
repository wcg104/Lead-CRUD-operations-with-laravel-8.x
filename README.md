
Laravel CRUD operation for lead
======



Installation
-----

Run a command,

```
composer require wcg104/lead
```
To publish configurations,

```
php artisan vendor:publish --tag=lead
```


Usage
-----
To use CRUD API operation for lead module Run below command.

Run Migration
```
php artisan migrate
```
Add resource route in route file
```php
// To use api resource add this in route and change name of lead according to your requirement

Route::apiResource('lead', LeadController::class);
```
License
-----
This package is licensed under the `MIT` License. Please see the [License File] for more details.
