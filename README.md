# Laravel Ban

[![Latest Stable Version](https://poser.pugx.org/stylers/laravel-ban/version)](https://packagist.org/packages/stylers/laravel-ban) 
[![Total Downloads](https://poser.pugx.org/stylers/laravel-ban/downloads)](https://packagist.org/packages/stylers/laravel-ban) 
[![License](https://poser.pugx.org/stylers/laravel-ban/license)](https://packagist.org/packages/stylers/laravel-ban) 
[![Build Status](https://travis-ci.org/stylers-llc/laravel-ban.svg?branch=master)](https://travis-ci.org/stylers-llc/laravel-ban) 
[![codecov](https://codecov.io/gh/stylers-llc/laravel-ban/branch/master/graph/badge.svg)](https://codecov.io/gh/stylers-llc/laravel-ban) 
[![Maintainability](https://api.codeclimate.com/v1/badges/ed5dbec66cac2d9b5d73/maintainability)](https://codeclimate.com/github/stylers-llc/laravel-ban/maintainability)

## Requirements
- PHP >= 8.1
- Laravel ~10.x

## Installation
```bash
composer require stylers/laravel-ban
```

You can publish the migration
```bash
php artisan vendor:publish --provider="Stylers\LaravelBan\Providers\BanServiceProvider"
```

After the migration has been published, you can run the migrations
```bash
php artisan migrate
```

## Usage
* How to add User to Bannable
```php
use Stylers\LaravelBan\Contracts\Models\Traits\BannableInterface;
use Stylers\LaravelBan\Models\Traits\Bannable;

class User extends Authenticatable implements BannableInterface
{
    use Notifiable;
    use Bannable;
}
```

## Ban
```php
use Carbon\Carbon;

$user = User::first();

$comment = "Reason of ban."; // ?string
$startAt = Carbon::addWeek(); // ?DateTimeInterface
$endAt = Carbon::now()->addWeeks(2); // ?DateTimeInterface

$ban = $user->ban(); // Ban without comment and timestamps (start_at, end_at) - never expire
$ban = $user->ban($comment, null, $endAt); // Ban for 2 weeks with comment
$ban = $user->ban($comment); // Ban without expire
$ban = $user->ban($comment, $startAt, $endAt); // Ban for a week with comment from next week
```

## Unban
Remove active bans
```php
$user = User::first();
$unbans = $user->unban();
```

## Events
```php
use Stylers\LaravelBan\Events\Banned;
use Stylers\LaravelBan\Events\Unbanned;
```

## Middleware for User
* Update `$routeMiddleware` in `App\Http\Kernel.php`
```php
use Stylers\LaravelBan\Http\Middleware\CheckUserBan;

protected $routeMiddleware = [
    ...
    'check_user_ban' => CheckUserBan::class,
];
```

* Update your routes in `routes/` or `App\Providers\RouteServiceProvider`
```php
protected function mapWebRoutes()
{
    Route::middleware('web', 'check_user_ban')
         ->namespace($this->namespace)
         ->group(base_path('routes/web.php'));
}
``` 
