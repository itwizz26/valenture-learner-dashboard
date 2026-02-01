# Learner Progress Dashboard - Coding Challenge

The goal of this coding challenge is to add some new functionality to the given simple
full-stack web application to allow a user to view learner course progress on a new
dashboard. The dashboard should allow basic filterin

## Tech stack

```
Laravel 12
PHP 8.5
SQLite
Inertia/Vue 3
Tailwind CSS v4
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

Visit [Leaner-progress](http://localhost:8000/learner-progress) in your browser.


### Code Quality

To maintain high code quality and PSR-12 compliance, this project uses **Laravel Pint**. 

To run the linter and check any code smells:
`./vendor/bin/pint`

### Technical Decisions & Architecture

#### Architecture: Modular Monolith

While the challenge is small, I implemented a Service-Repository Pattern to demonstrate a scalable, production-ready architecture. This separates the application into distinct layers:

Controller Layer: Solely responsible for handling HTTP input and returning responses.

Service Layer (Domain): Encapsulates the business logic (filtering and sorting logic). This makes the logic reusable for API endpoints or Console commands.

Repository Layer (Infrastructure): Abstracts the Eloquent queries. This allows the underlying data source to be swapped (e.g., from SQLite to a remote API or a different SQL dialect) without touching the business logic.

Service-Repository Pattern: Decouples business logic from Eloquent, making the code unit-testable and maintainable.

Form Requests: Implemented for strict input validation and to ensure the application boundaries are secure.

Eager Loading: Used `with(['courses'])` to ensure the application avoids N+1 query issues, maintaining performance regardless of dataset size.

##### Frontend UI decisions

Inertia.js: Chosen to provide a Single Page Application (SPA) experience without the complexity of a separate API/JWT setup.

Tailwind v4 JIT: Utilized the latest CSS engine for high-performance styling and minimal bundle size.

Vite: Compiles and caches css and js in public/build/assets (our SPA loads faster)

#### Key Engineering Principles Applied

Dependency Injection & Inversion of Control: I used Laravel's Service Container to bind LearnerRepositoryInterface to EloquentLearnerRepository. This adheres to the Dependency Inversion Principle (SOLID).

Performance (N+1 Prevention): I utilized Eager Loading (with(['courses'])) to ensure that regardless of the number of learners, the application executes a constant number of database queries.

Database-Level Sorting: Sorting by progress (a pivot table attribute) is handled via SQL Joins in the repository. This is significantly more performant than sorting Collections in PHP memory, especially as the dataset grows.

Strict Typing: Every class uses declare(strict_types=1); and full type-hinting to ensure code reliability and better IDE support.

### Copyright

[Itwizz26](https://github.com/itwizz26/) <|> [Daniel Mathebula](https://portfolio-c08.pages.dev/) <|> &copy; 2026

### License

[GNU GENERAL PUBLIC LICENSE](LICENSE)
