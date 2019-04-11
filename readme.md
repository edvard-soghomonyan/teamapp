# TeamApp

##1 How to install
###1.1 Clone the this repo - `git clone https://github.com/edvard-soghomonyan/teamapp.git`
###1.2 Update `.env` file and set proper `DB` connection values for `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD`, assumed the `mysql is used, in other cause make changed to all other db configs
###1.3 run `composer install`
###1.4 run `php artisan migrate && php artisan db:seed`


##2 How to use
###2.1 After successful installation following routes would be available for calls
###`POST: {LOCAL_HOST}/api/users , DATA: [name{required}, email:{required|unique|email}]`
###`GET: {LOCAL_HOST}/api/v1/users , PARAM: [api_token{required}]`
###`GET: {LOCAL_HOST}/api/v1/users/teams , PARAM: [api_token{required}]`
###`PUT: {LOCAL_HOST}/api/v1/users , DATA: [api_token{required}, name{required}]`
###`DELETE: {LOCAL_HOST}/api/v1/users , DATA: [api_token{required}]`
###`POST: {LOCAL_HOST}/api/v1/teams , DATA: [api_token{required}, title{required}]`
###`PUT: {LOCAL_HOST}/api/v1/teams/{teamID} , DATA: [api_token{required}, title{required}]`
###`POST: {LOCAL_HOST}/api/v1/teams/{teamID}/assign/{userId} , DATA: [api_token{required}]`
###`POST: {LOCAL_HOST}/api/v1/teams/{teamID}/assign/{userId}/owner , DATA: [api_token{required}]`
###`DELETE: {LOCAL_HOST}/api/v1/teams/{teamID} , DATA: [api_token{required}]`

##3 What I would have done if I had more time
###3.1 I would have create more clear response structure (for success and error)
###3.2 I would have create a resource collection files so in the response only those fields that are available to see for the user would be available ONLY
###3.3 I would fix the issue when user is assigned to the team as `member` and when you assign him as a `owner` the previous role should be removed
###3.4 I would for sure remove all of the duplicate code that currently exists and make sure that there are no duplicated

##4 What I used and why
###4.1 `"spatie/laravel-permission": "^2.37"` package for the roles and permissions
###4.2 `Soft Deletes` for the eloquent tables to keep all records but mark them as `deleted` at the same time (for maybe restore functionality)
###4.3 `phpunit` for testing

##5 Why I make app this way
###5.1 I chose to use Repository Pattern because it's easy to understand, code is very clear and testable

##6 PhpUnit test results  
###PHPUnit 7.2.6 by Sebastian Bergmann and contributors.
   
###   .........                                                           9 / 9 (100%)
   
###   Time: 2.87 seconds, Memory: 22.00MB
   
###   OK (9 tests, 23 assertions)