## Installation

1. clone repo
2. `cp .env.example .env`
3. `composer install`
4. `php artisan key:generate`
5. `php artisan jwt:secret`
6. `php artisan db:seed` (seed admin for login)

## Testing

run `php artisan test`

## Api Docs

visit `/docs`