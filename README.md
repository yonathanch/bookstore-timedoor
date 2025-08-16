Run the bookstore application:

1.      Create database name:"bookstore" in mysql :
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=bookstore
        DB_USERNAME=root
        DB_PASSWORD=

2.      Run Terminal vscode:
        php artisan migrate
        php artisan db:seed

3.      Run the server:
        php artisan serve
