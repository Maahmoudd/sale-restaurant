# Mini Restaurant Reservation APIs

## Table of Contents

- [Introduction](#introduction)
- [Database Schema](#database-schema)
- [API Endpoints](#api-endpoints)
    - [1. Check Availability](#1-check-availability)
    - [2. Reserve Table](#2-reserve-table)
    - [3. List Menu Items](#3-list-menu-items)
    - [4. Place Order](#4-place-order)
    - [5. Pay](#5-pay)
- [Design Patterns](#design-patterns)
- [Bonus Features](#bonus-features)
- [Docker](#docker)
- [Authentication](#authentication)
- [Postman Collection](#postman-collection)

## Introduction

This project offers a suite of APIs designed to manage a small-scale restaurant reservation system. The features include checking the availability of tables, making reservations, listing menu items, placing orders, and generating customer invoices.

## Database Schema

### Entities and Attributes

- `tables`: id, capacity
- `reservations`: id, table_id, customer_id, from_time, to_time
- `meals`: id, price, description, available_quantity, discount
- `orders`: id, table_id, reservation_id, customer_id, user_id (waiter), total, paid, date
- `order_details`: id, order_id, meal_id, amount_to_pay
- `customers`: id, name, phone
- `waiting_list`: id,customer_id, capacity,to_time, from_time
- `invoices` : id,user_id , order_id , customer_id , total

## API Endpoints

## Path Table

| Method | Path                    | Description        |
|--------|-------------------------|--------------------|
| POST   | /api/login              | Authenticate User  |
| POST   | /api/check-availability | Check Availability |
| POST   | /api/reserve-table/     | Reserve Table      |
| GET    | /api/list-menu-items/   | List Menu Items    |
| POST   | /api/place-order/       | Place Order        |
| POST   | /api/checkout/          | Complete Checkout  |


### 1. Authenticate User

Endpoint: `/api/login`

Description: Authenticate user and generate token

**Headers:**
- Content-Type: "application/json"
- Accept: "application/json"

**Request Body:**
```json
{
    "email": "smitham.anastacio@example.com",
    "password": "password"
}

```
### 2. Check Availability

Endpoint: `/api/check-availability`

Description: Checks table availability in specific time for number of customers

**Headers:**
- Content-Type: "application/json"
- Accept: "application/json"
- Authorization: "Bearer {{token}}"

**Request Body:**
```json
{
    "table_id": 12,
    "from_time": "2024-07-23 18:00:00",
    "to_time": "2024-07-23 20:00:00",
    "capacity": 9
}
```

### 3. Reserve Table

Endpoint: `/api/reserve-table`

Description: Reserves a table


**Headers:**
- Content-Type: "application/json"
- Accept: "application/json"
- Authorization: "Bearer {{token}}"

**Request Body:**
```json
{
    "table_id": 12,
    "customer_id": 1,
    "from_time": "2024-07-22 18:00:00",
    "to_time": "2024-07-23 20:00:00"
}
```

### 4. List Menu Items

Endpoint: `/api/list-menu-items`

Description: Displays the restaurant available menu items


**Headers:**
- Content-Type: "application/json"
- Accept: "application/json"
- Authorization: "Bearer {{token}}"

### 5. Place Order

Endpoint: `/api/place-order`

Description: Place an order for a table, applying all discounts for each meal.

**Headers:**
- Content-Type: "application/json"
- Accept: "application/json"
- Authorization: "Bearer {{token}}"

**Request Body:**
```json
{
    "table_id": 1,
    "reservation_id": 1,
    "customer_id": 1,
    "user_id": 1,
    "order_items": [
        {
            "meal_id": 1,
            "quantity": 4
        },
        {
            "meal_id": 2,
            "quantity": 4
        }
    ]
}
```

### 6. Checkout

Endpoint: `/api/checkout`

Description: Checkout and print an invoice for a table. Two ways of handling checkout are available:
1. Add 14% taxes and 20% service charge => TaxPaymentStrategy.
2. Add a 15% service charge only => ServicePaymentStrategy.

**Headers:**
- Content-Type: "application/json"
- Accept: "application/json"
- Authorization: "Bearer {{token}}"

**Request Body:**
```json
{
    "order_id": 9,
    "payment_method": 2
}
```
## Design Patterns

- Action Design Pattern for handling single responsibility methods 
- Repository Design Pattern for handling interaction with database separated from the business logic
- Strategy Design Pattern for handling different payment ways
## Bonus Features

- **Waiting List**: Extend the schema to handle a waiting list when tables are at maximum capacity.
- **Unit Tests**: Tested the functionality of all the endpoints.

## Authentication

Authentication With Sanctum

## Postman Collection

To facilitate testing and integration, provide a Postman collection that includes sample requests for each API endpoint, along with expected responses. This will help users understand how to interact with your API.

[Link to Postman Collection](https://documenter.getpostman.com/view/36493973/2sA3kXCzbA) - Update this link once you create the collection.


- BaseUrl: your app link
- bearer_token : the token from login
- In Every Api Body have example about request


# Requirements
- PHP 8.2
- Laravel 11
- MySQL

## Getting Started


## Clone
Clone this repo to your local machine using https://github.com/Maahmoudd/sale-restaurant.git
and run
```
git clone https://github.com/Maahmoudd/sale-restaurant.git
cd sale-restaurant
cp .env.example .env
composer install
composer dumpautoload
```

# Laravel sail
run  ./vendor/bin/sail up -d to setup environment by docker
```
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
```

## Run Migrations
```bash
 ./vendor/bin/sail artisan migrate --seed
 ````
## Run Test
```bash
 ./vendor/bin/sail artisan test
 ````

