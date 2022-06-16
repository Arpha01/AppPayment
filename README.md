### Hello 👋 welcome to my payment gateway repository.

AppPayment is a payment gateway implementation and integration built using Laravel 9.

#### Tools used in the development

| Tools                                | Version       |
| -------------                        |:-------------:|
| Composer                             | 2.1.14        |
| Midtrans core API (Payment gateway)  | -             |
| Laravel 9.11                         | 9.11          |
| PHP                                  | 8.0.2         |
| Laravel Sanctum (Authentication)     | 2.15          |
| Laragon                              | 5.0           |
| Postman                              | -             | 

# Installation
* Clone this repository 
* Extract files
* Open command prompt or terminal, run `cd pathtodirectory`
* In terminal run `composer install`
* Rename .env.example file to .env
* In the .env file replace DB_CONNECTION, DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD, adjust it to your database configuration
* In terminal run `php artisan migrate`
* In terminal run `php artisan db:seed`
* In terminal run `php artisan serve`

You're done, the API will run on localhost:8000/api

# Database Structure
### Class Diagram
![image](https://user-images.githubusercontent.com/11209553/174081989-9958cff8-2bec-40cc-a779-66a1574d5aa0.png)

# Authentication
### Users
There are 2 types of users, an organization user, and ordinary user



