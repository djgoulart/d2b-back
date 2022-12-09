<p align="center"><a href="javascript:void(0)" target="_blank"><img src="https://raw.githubusercontent.com/djgoulart/d2b-back/main/public/logo.svg" width="400" alt="D2B Logo"></a></p>

<p align="center">

</p>

## About D2B Backend (work in progress)

This project is <b>in development</b> and is the backend part of the [TydyDaily challenge](https://github.com/TidyDaily/developer-test). 

# Project Structure

The project was built using (DDD) Domain Driven Design and (TDD) Test Driven Development. The Domain structure was built inside the src directory as illustrated below.

<p>
<img src="https://raw.githubusercontent.com/djgoulart/d2b-back/3c2744e831754f79ccfc5b7d9f20d773a8c659cd/public/folders.png" width="400" alt="D2B Logo">
</p>

# Running the application

The application was not published yet, but it's possible to run it in your local development environment using Docker and Docker Compose.

- clone the repository
```bash
git clone git@github.com:djgoulart/d2b-back.git
 ```
- run the containers:

```bash
docker compose up -d --build  
```

## Running the tests

- Attach a shell to the laravel app container.

```bash
docker exec -it d2b-back-laravel.test-1 bash  
```
- run the tests
```bash
php artisan test  
```

## Implemented API Routes

```bash
  GET|HEAD      api/health-check 
  POST          api/auth ......Api\AuthController@login
 
  POST          api/users ......Api\UserController@store
```

## Create a customer
Use any Rest client to create a new customer, passing the correct parameters, as demonstrated below.
```js
// POST /api/users
{
	"name": "Customer Name",
	"email": "customer@email.com",
	"password": "123456",
	"password_confirmation": "123456"
}
```

## Authenticating
Use any Rest client to authenticate, passing the correct parameters, as demonstrated below.
```js
// POST /api/auth/login
{
	"email": "email@an_existing_user.com",
    "password": "password"
}
```
## Create a Bank Account (to be implement)
Use any Rest client to create a new bank account, passing the correct parameters, as demonstrated below.
```js
{
	"owner": "an_existing_user_id"
}
```
## View the balance (to be implement)
```js
{}
```
## Make a deposit (to be implement)
```js
{}
```
## Buy something (to be implement)
```js
{}
```
## List the account transactions (to be implement)
```js
{}
```

<br />

## Challenge Details

Build a simplified banking system, using Laravel and ReactJS.
 - The system has 2 types of users.
    - [x] Customer
    - [] Admin

## Customer Stories
 - [x] A user can create a new account with name, email and password. 
 - [x] A user starts with 0 balance.
 - [x] A user can deposit more money to his account by uploading a picture of a check and entering the amount of the check. if the check is approved by an admin, the money is added to the bank account.
 - [x] To buy something, the user enters the amount and description; a user can only buy something if she has enough money to cover the cost.
 - [ ] a user can see a list of balance changes including time and description.

 ## Admin Stories
 - [ ] An admin account is already created with a hard coded username and password.
 - [ ] An admin can see a list of pending check deposit pictures with amount and picture and click to approve or deny the deposit.
 - [ ] An admin can’t be also a customer.



## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
