<!-- ## Installation

1. clone repo
2. `cp .env.example .env`
2. `cp .env.example .env.testing` (for testing)
3. update **.env** & **.env.testing** database credentials as needed
4. `composer install`
5. `php artisan key:generate`
6. `php artisan jwt:secret`
7. `php artisan db:seed` (seed admin for login)
8. `php artisan serve`

## Testing

run `php artisan test`

## Api Docs

visit `/docs` -->

## Installation

**Prerequisites**

- PHP 8.0
- Laravel 8.x
- MongoDB 4.2

**Plugins**
- [mongodb/laravel-mongodb](https://github.com/mongodb/laravel-mongodb){target="_blank"}
- [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth){target="_blank"}

**Steps:**

1. **Clone the repository**

2. **Create environment files**

   ```bash
   cp .env.example .env
   cp .env.example .env.testing
   ```

3. **Configure environment variables**

   Open **.env** and **.env.testing** and update credentials and any other relevant environment variables as needed.

4. **Install dependencies**

   ```bash
   composer install
   ```

5. **Generate application key**

   ```bash
   php artisan key:generate
   ```

6. **Generate JWT secret**

   ```bash
   php artisan jwt:secret
   ```

7. **Seed Database**
   
   Run this command to generate admin user for login
   ```bash
   php artisan db:seed
   ```
   email: admin@mail.com
   passwod: 12345678

8. **Start development server**
   
   ```bash
   php artisan serve
   ```

## Testing

   ```bash
   php artisan test
   ```

## API Documentation
   visit this postman [docs](https://documenter.getpostman.com/view/38470841/2sAXqs83HK){target="_blank"}