## About

Boilerplate project for setting up a REST API. Using Laravel 8 with passport authentication. I made this to use it as backend for mobile apps. To change the format of the responses, have a look in App/Http/Controllers/API/BaseController.php. This i sthe controller that UserController is extending.  

The unauthenticated exception response is in app/Exceptions/Handler.php


## Install

* Create database
* Add database details to .env
* Run `composer install`
* Run `php artisan migrate `
* Run `php artisan key:generate `
* Run `php artisan passport:install`
