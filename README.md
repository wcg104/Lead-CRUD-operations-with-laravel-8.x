
Laravel CRUD operation for lead
======

[![Total Downloads](https://poser.pugx.org/wcg104/lead/downloads)](https://packagist.org/packages/wcg104/lead)  [![License](https://poser.pugx.org/wcg104/lead/license)](https://packagist.org/packages/wcg104/lead)


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
For testing, need to set up testing environment.
Update database detail in phpunit.xml file
```php
     <php>
            <env name="APP_ENV" value="testing"/>
            <env name="BCRYPT_ROUNDS" value="4"/>
            <env name="CACHE_DRIVER" value="array"/>
            <env name="DB_CONNECTION" value="sqlite"/> // write database connection if you want to test in different database
            <env name="DB_DATABASE" value=":memory:"/> //write your database name if you want to test in different database
            <env name="MAIL_MAILER" value="array"/>
            <env name="QUEUE_CONNECTION" value="sync"/>
            <env name="SESSION_DRIVER" value="array"/>
            <env name="TELESCOPE_ENABLED" value="false"/>
     </php>
```
To perform testing run below command
```
php artisan test
```
License
-----
This package is licensed under the `MIT` License. Please see the [License File] (https://github.com/wcg104/lead/blob/master/LICENSE) for more details.