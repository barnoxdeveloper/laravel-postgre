Laravel Sanctum API, Repository & Service Pattern Project.

-   Laravel Laravel v10.16.1
-   Laravel Sanctum.
-   Repository Pattern.
-   Service Pattern.
-   PostgreSQL

How to install?

1. Clone this repository | git clone https://github.com/barnoxdeveloper/laravel-postgre.git
2. In terminal : composer update
3. In terminal : npm update
4. Copy .env.example and rename to .env
5. Set up the database name
6. In terminal : php artisan key:generate
7. In terminal : php artisan config:clear
8. In terminal : php artisan config:cache
9. In terminal : php artisan route:cache
10. In terminal : php artisan migrate
11. In terminal : php artisan storage:link
12. In terminal : php artisan serve
13. Done.

--- Endpoints ---

Login API Endpoints
POST /api/v1/login: Login user
POST /api/v1/logout: Login user (Requires authentication)

User API Endpoints
GET /api/v1/users: Get a list of all users (Requires authentication)
GET /api/v1/users/{id}: Get a specific user by ID (Requires authentication)
POST /api/v1/users: Create a new user (Requires authentication)
PUT /api/v1/users/{id}: Update a user by ID (Requires authentication)
DELETE /api/v1/users/{id}: Delete a user by ID (Requires authentication)

Product API Endpoints
GET /api/v1/products: Get a list of all products (Public endpoint)
GET /api/v1/products/{id}: Get a specific product by ID (Public endpoint)
POST /api/v1/products: Create a new product (Requires authentication)
PUT /api/v1/products/{id}: Update a product by ID (Requires authentication)
DELETE /api/v1/products/{id}: Delete a product by ID (Requires authentication)
