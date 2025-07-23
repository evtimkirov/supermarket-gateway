# Supermarket gateway project
Supermarket checkout process that calculates the total price of a number of items.

## How to start
Run `docker compose up --build`

## Available ports
### Main page
http://localhost:8000

There are two tables - one for the available products and one for the orders.
* The first table contains all the available products with options to add and with calculation
  * When clicking on the _add_ button it hits the API endpoint for the calculation
  * When clicking on the _checkout_ button it makes order with all the selected items via AJAX request, too.
* The second table shows the orders with the current status and the already checkout product names

### Login to the admin panel
http://localhost:8000/login

There are two pages in the admin panel: one for products and one for orders. The products page offers CRUD options, while the orders page provides options for changing statuses.

```
email: admin@siteground.com
password: password
```

### Database relationship scheme
```
products
   └──< promotions (1:N)

products
   └──< order_product >──┐
                         │
orders   ────────────────┘  (M:N with order_product)
```
