# Test task

## Requirements
* PHP 7.4
    - This version has a lot of useful features such as typed properties, arrow functions, null coalescing assignment operator etc. In case of need we can increase performance by turning on OPcache.
* Mysql 5.7.29
    - Probably the most popular version of Mysql.
* Laravel 8.0 framework 
    - The Latest version of framework with all with the newest features. A little overhead for each small project but although easy to deploy and use.
* RabbitMQ 3.8
    - I really like this queue broker. A lot of settings for huge projects and at the same time easy to use.

## Installation

##### Clone project
> git clone https://github.com/ibabich88i/take-away.git

##### Copy .env file from .env.example

> `cp .env.example .env`

##### Deploy environment
> `docker-compose build`

> `docker-compose up -d`

##### Installing composer dependencies
> `docker-compose exec php composer install`

##### Run migrations
> `docker-compose exec php artisan migrate`

## Endpoints
### Send email notification
**POST** method  
> `api/messages  `

Example of body:  
*Password forgotten message*
```json
{
    "recipients" : [
        {
            "email":"alebab@ciklum.com"
        }
    ],
    "data" : {
        "token" : "dwafwffwafawfkmfwakfkwnfknawfwaf"
    },
    "module" : "user",
    "action" : "change-password"
}
```
*Customer registered message*
```json
{
    "recipients" : [
        {
            "email":"alebab@ciklum.com"
        }
    ],
    "data" : {
        "name" : "New user"
    },
    "module" : "user",
    "action" : "customer-registered"
}
```

## Console commands
### Send email notification
> `php artisan email:send rec module action data` 
- rec `(string)` - Recipient of email
- module `(string)` - Module name
- action `(string)` - Action in the module
- data `(array)` - Data for email

Example
> `docker-compose exec php artisan email:send alebab@ciklum.com user change-password 'token':'token text'`
