# Install this demo app

1. Clone the repository and install deps
 
 ```bash
git clone XXXX
composer install
```

2. Set up your credentials in `.env`

Make sure to set up database and Algolia credentials.

3. Install DB and import data

```php
php artisan migrate
php artisan db:seed
```

4. Import data to Algolia

```php
php artisan scout:import 'App\Airport'
```
