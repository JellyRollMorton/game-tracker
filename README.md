## About Game Tracker

Game Tracker can be used to track and rank players in any two-player game with scores.  It was initially developed to track Foosball player rankings.

## Requirements

The application is written in PHP, using the Laravel framework, and a PostgreSQL database.  The following requirements are needed:

- PHP 7.0+
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- PostgreSQL 9.5+ 

The instructions below assume that you are using the [Homestead](https://laravel.com/docs/5.5/homestead) (version 5.5 is recommended), however this should work in most environments as long as the requirements above are met.

## Installation Instructions

Clone the project and enter the project directory

```shell
git clone https://github.com/JellyRollMorton/game-tracker.git
cd game-tracker
```

Install PHP dependencies via Composer

```shell
composer install
```

Initialize the configuration/environment file.  If you are not using Homestead, you will also want to update the .env file to provide the credentials of your PostgreSQL database.  You can also choose to update the APP_NAME variable, which changes the title of the application within the UI.

```shell
cp .env.example .env
```

Generate the Laravel key

```shell
php artisan key:generate
```

Create all database objects

```shell
php artisan migrate
```

By defaut, there is no user and user registration is disabled.  You will need to create a new user via the tinker interface.

```shell
php artisan tinker
```

Enter in the following code at the tinker prompt to create a user:

```php
$user = new App\User();
$user->name = 'My Name';
$user->password = Hash::make('insert password here');
$user->email = 'test@example.com';
$user->save();
```

Exit tinker using Ctrl+C

The application should now be accessible via site name that was defined during the Homestead configuration. 