# api-laravel
restfull api with passport

# System Requirements
* php 7^
* mysql

# How to Running 
* configure env.
* composer install
* php artisan key:generate
* php artisan migrate
* php artisan passport:install
* php artisan serve

# Tested with postman
* register user first
* login user
* use access token

# Login User to get token
* {
	"name":"admin",
	"email":"admin@gmail.com",
	"password":"admin",
	"c_password":"admin"
  }

# Mapping api
## user api
* post('login');
* post('register');

## master letter
* get('master/letter/alldata');
* get('master/letter/getdata/{id}');
* post('master/letter/insert');
* put('master/letter/update/{id}');
* delete('master/letter/delete/{id}');

## management
* get('management/alldata');
* get('management/getdata/{id}');
* post('management/insert');
* post('management/update/{id}');
* delete('management/delete/{id}');

## pagination
* get('management/pagination/alldata/{show_data},{page}');
