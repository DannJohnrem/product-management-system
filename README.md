# Product Management System Project

This project is an Product Management System built with the latest versions of Vue.js and Laravel. It includes authentication, product management. This `README.md` provides instructions for setting up and running the application.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)

## Prerequisites

- PHP 8.x
- Laravel 10.x
- Node.js (Latest LTS version)
- Composer (Latest version)
- Vue.js 3.x
- Git
- Docker (optional, for development with Docker)

## Installation

1. **Clone the Repository**

    ```bash
   git clone https://github.com/DannJohnrem/product-management-system.git
   cd product-management-system
    ```
2. **Install PHP Dependencies**

    ```bash
    composer install
    ```
3. **Install JavaScript Dependencies**

    ```bash
    npm install
    ```
4. **Copy Environment File**

    ```bash
    cp .env.example .env
    ```
5. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```
6. **Run Migrations and Seeders**

    ```bash
    php artisan migrate --seed
    ```
6. **Compile Assets**

    ```bash
    npm run dev
    ```

    For production, use:

     ```bash
    npm run build
    ```
6. **Run the Development Server**

    ```bash
    php artisan serve
    ```
The application should now be accessible at http://localhost:8000.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


