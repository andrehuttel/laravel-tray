## Instalação
```sh
git clone https://github.com/andrehuttel/laravel-tray.git
```

```sh

./vendor/bin/sail up -d
```

```sh
./vendor/bin/sail bash
```

```sh
composer install
```


Run this command to generate key
```sh
php artisan key:generate
```

```sh
This project aims to enhance code quality and maintainability by implementing the following improvements:
```

```sh
Abstraction of Logic into Service Layer
```

```sh
Type Annotations for Methods
```

```sh
Documentation with Docblocks
```

## API Endpoints

### Sellers

- **List All Sellers**
  - `GET /api/sellers`
  - Retrieves a list of all sellers.

- **Create Seller**
  - `POST /api/sellers`
  - Creates a new seller.

- **Show Seller**
  - `GET /api/sellers/{id}`
  - Retrieves details of a specific seller.

- **Update Seller**
  - `PUT /api/sellers/{id}`
  - Updates an existing seller.

- **Delete Seller**
  - `DELETE /api/sellers/{id}`
  - Deletes a seller.

### Sales

- **List All Sales**
  - `GET /api/sales`
  - Retrieves a list of all sales.

- **Create Sale**
  - `POST /api/sales`
  - Creates a new sale.

- **Show Sale**
  - `GET /api/sales/{id}`
  - Retrieves details of a specific sale.

- **Update Sale**
  - `PUT /api/sales/{id}`
  - Updates an existing sale.

- **Delete Sale**
  - `DELETE /api/sales/{id}`
  - Deletes a sale.

- **List Sales by Seller**
  - `GET /api/sales/seller/{seller}`
  - Retrieves a list of all sales by a specific seller.