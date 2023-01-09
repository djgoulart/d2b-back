<p align="center"><a href="javascript:void(0)" target="_blank"><img src="https://raw.githubusercontent.com/djgoulart/d2b-back/main/public/logo.svg" width="400" alt="D2B Logo"></a></p>

<p align="center">

</p>

## About D2B Backend

This project is the backend part of the [TydyDaily challenge](https://github.com/TidyDaily/developer-test). 

# Project Structure

The project was built using (DDD) Domain Driven Design and (TDD) Test Driven Development. The Domain structure was built inside the src directory as illustrated below.

<p>
<img src="https://raw.githubusercontent.com/djgoulart/d2b-back/3c2744e831754f79ccfc5b7d9f20d773a8c659cd/public/folders.png" width="400" alt="D2B Logo">
</p>

# Running the application

You can test de application by using the [web application](https://d2b-front-djgoulart.vercel.app/) developed as part of this challenge. [CLICK HERE](https://github.com/djgoulart/d2b-front) if you want to see the front-end project repository.
<br />

# Running in local development

To run this project in your local development environment, use Docker and Docker Compose and follow the instructions bellow.

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

## API URL
```bash
https://d2b.triup.dev.br/api  
```

## Implemented API Routes

```js
// Authentication
POST      api/auth/login

/**
 * ===========================================
 * User related endpoints
 * ===========================================
 */

/*
 * Create a new User with an customer account.
 * @body {Object}
 * @body_param String name
 * @body_param String email
 * @body_param String password
 * @body_param String password_confirmation
 */
POST      api/users

/* 
 * Show a given user info
 * @param String user
 */
GET      api/users/{user}

/**
 * ===========================================
 * Account related endpoints
 * ===========================================
 */

/* 
 * Show a given account info
 * @param String accountId
 */
GET|HEAD  api/accounts/{accountId}

/**
 * ===========================================
 * Transactions related endpoints
 * ===========================================
 */

/* 
 * Show a list of transactions
 * @query_params: [account, approved, type, needs_review]
 * 
 * @account String
 * @approved Boolean
 * @type String 'deposit'|'expense'
 * @needs_review Boolean
 */
GET|HEAD  api/transactions

/*
 * Create a new transaction
 *
 * @body {Object}
 * @body_param String account
 * @body_param String description
 * @body_param String 'deposit|expense' type 
 * @body_param Number amount
 * @body_param Blob receipt
 */
POST      api/transactions

/*
 * Show given transaction info
 * @param String transaction
*/ 
GET|HEAD  api/transactions/{transaction}

/* 
 * Update transaction approval status
 * @param String transaction
 * @body {Object}
 * @body_param Boolean approved
 */
PUT       api/transactions/{transaction}/send-for-approval
```

<br />

## Challenge Details

Build a simplified banking system, using Laravel and ReactJS.
 - The system has 2 types of users.
    - [x] Customer
    - [x] Admin

## Customer Stories
 - [x] A user can create a new account with name, email and password. 
 - [x] A user starts with 0 balance.
 - [x] A user can deposit more money to his account by uploading a picture of a check and entering the amount of the check. if the check is approved by an admin, the money is added to the bank account.
 - [x] To buy something, the user enters the amount and description; a user can only buy something if she has enough money to cover the cost.
 - [x] a user can see a list of balance changes including time and description.

 ## Admin Stories
 - [x] An admin account is already created with a hard coded username and password.
 - [x] An admin can see a list of pending check deposit pictures with amount and picture and click to approve or deny the deposit.
 - [x] An admin can’t be also a customer.



## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
