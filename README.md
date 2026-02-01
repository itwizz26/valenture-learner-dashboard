# Learner Progress Dashboard - Coding Challenge

The goal of this coding challenge is to add some new functionality to the given simple
full-stack web application to allow a user to view learner course progress on a new
dashboard. The dashboard should allow basic filterin

## Tech stack

```
Laravel 12
PHP 8.5
SQLite
Vue Js
Tailwind Css
```

## Getting Started

### Getting your environment ready

Before you start. Ensure that you have all these extensions enabled in your php.ini configuration file for a smooth Laravel 12 experience.

```
openssl
curl
fileinfo
mbstring
pdo_sqlite
sqlite3
pdo_mysql
```

Also, if you are on PHP 8.5, you might want to update your config/database.php file with this, if you haven't done it already.

```
Find: Lines 61 and 81 (and anywhere else PDO::MYSQL_ATTR_SSL_CA appears).
Change: PDO::MYSQL_ATTR_SSL_CA To: Pdo\Mysql::ATTR_SSL_CA
```

This ensures you don't see warning messages like this:
```
Deprecated: Constant PDO::MYSQL_ATTR_SSL_CA is deprecated since 8.5, use Pdo\Mysql::ATTR_SSL_CA instead in 
./config/database.php on line 61
```

Why this is happening?

`In PHP 8.5, the development team moved MySQL-specific constants into their own namespace (Pdo\Mysql) to clean up the global space. Laravel 12's default database.php still uses the old global PDO:: prefix`

### Running the solution

#### The Server/API - Laravel
1. Run `composer install`
2. Configure your `.env` file from the example. Ensure this SQLite database connection string is present inside your .env `DB_CONNECTION=sqlite`
3. Generate the App Key: `php artisan key:generate`
4. Run migrations and seeders: `php artisan migrate --seed`
5. Start the development server: `php artisan serve`

Now head on to your favourite browser and open [http://localhost:8000/](http://localhost:8000) to see your new Laravel 12 app or open this link to check the server status [http://localhost:8000/up](http://localhost:8000/up)

#### The Client/UI - Vue.js

1. Run `npm install`
2. run `npm run start`


### Testing the app


### Copyright

[Itwizz26](https://github.com/itwizz26/) <|> [Daniel Mathebula](https://portfolio-c08.pages.dev/) <|> &copy; 2026

### License

[GNU GENERAL PUBLIC LICENSE](LICENSE)
