# Laravel Ban

## Requirements
- PHP >= 7.1.3
- Laravel ~5.x

## Installation
```bash
composer require stylers/laravel-ban
```

You can publish the migration
```bash
php artisan vendor:publish --provider Stylers\LaravelBan\Providers\BanServiceProvider --tag migrations
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
$expiredAt = Carbon::now()->addWeek(); // ?DateTimeInterface

$ban = $user->ban(); // Ban without comment and expire date
$ban = $user->ban($comment, $expiredAt); // Ban for a week with comment
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

## TODO
- [ ] Release
- [ ] Middleware for User
- [ ] Publish on [Packagist](https://packagist.org/)