# Business Requirements

There's a need for a **system** for placing some sort of **orders** for **products** by anonymous **clients**.

Each **product** is unique and is identified by some `name`.

Each **product** has random price at each point of time, which is obtained from 3-rd party service.

Each **order** can consist of many products.

Each **product** can be placed into order with any quantity, higher than one.

Each **product** has their own stock, which is obtained from 3-rd party service.

If **order** is placed with given **product** and **stock** is not available on this **product** we should not create an **order**.

We want to know total price of each order.

(OPTIONAL) We want to have custom currency implemented, so each order can be valued in "gold coins"

Write a system for handling this type of orders.

# Solution

Code in `./src`.
Tests in `./tests`.

PHPStan level: 9
Type coverage: 100%
Code coverage: 100%
Path coverage: ~93%

Send API Request:

```http request
POST http://localhost:8080/
Accept: application/json

{
   "products": [
      { "name": "some product", "amount": 30 },
      { "name": "some other product", "amount": 1 }
   ]
}
```

You'll get Response:

```json
{
  "message": "Order created",
  "products": [
    {
      "product": {
        "name": "some product"
      },
      "currentPrice": 80.3633035371659,
      "amount": 30,
      "stock": 47
    },
    {
      "product": {
        "name": "some other product"
      },
      "currentPrice": 112.26285852676824,
      "amount": 1,
      "stock": 26
    }
  ],
  "total_price": 2523.1619646417457,
  "coins": 200,
  "created_at": 1702915315
}
```

Or sometimes error, depending on warehouse availability.

```json
HTTP/1.1 500 Internal Server Error
Content-Type: application/json

{
  "message": "Out of stock for some product",
  "location": "\/app\/src\/Domain\/Product\/ProductSnapshot.php:22",
  "controller": "App\\Presentation\\Controller\\CreateOrderController::index",
  "client": "Apache-HttpClient\/4.5.14 (Java\/17.0.9)"
}
```
