# Tutorial Laravel 8 y Livewire - Sales system

https://www.udemy.com/course/sistema-de-ventas-laravel-8-y-livewire

## Concepts seen in the tutorial 
* PHP
* Laravel
* Livewire
* Composer

## Notes
* I used Docker.
* I used Laravel 9.
* In Sales view, added a button for add random product to sale (for testing sale module).
* The permissions module was not implemented, no one should be able to remove, edit or add permissions.
* The assignment module was replaced by a select multiple in the roles form.
* The field profile in users, has been removed because is not used.

# App
Sales system

# Composer packages used
* darryldecode/cart
* spatie/laravel-permission

# Deployment

First you have to download the repository 

    git clone https://github.com/demiancy/tutorial-laravel-1.git

The repository have the files for deploy app in Docker, with the next command you start the app in the port 3000

    docker-compose up

In case of not have Docker, you can copy the folder app into document root of your server.
