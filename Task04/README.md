# Web Application with Laravel Framework

This is a web application built on the **Laravel** framework. The game from previous labs has been reimplemented using Laravel.

## Installation

To install the application on Linux, run:

```bash
make install
```

This command will:
- Install PHP dependencies via Composer
- Copy `.env.example` to `.env`
- Generate the application key
- Create SQLite database
- Run database migrations
- Install npm dependencies
- Build frontend assets

## Running the Application

To start the development server:

```bash
make serve
```

The application will be available at http://localhost:8000

## Database

The SQLite database is stored in `database/database.sqlite`

## Testing

To run tests:

```bash
make test
```

## Requirements

- PHP 8.3 or higher
- Composer
- Node.js (npm)
- SQLite

## Project Structure

- `app/` - Application code (models, controllers, etc.)
- `database/` - Database migrations and seeds
- `public/` - Public assets and entry point
- `resources/` - Views and frontend resources
- `routes/` - Application routes
- `storage/` - Application logs and cache
- `tests/` - Test files

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
