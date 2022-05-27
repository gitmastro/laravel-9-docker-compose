# Executing commands in Laravel container

- List all artisan commands:

```bash
docker-compose exec myapp php artisan list
```

- List all registered routes:

```bash
docker-compose exec myapp php artisan route:list
```

- Create a new application controller named UserController:

```bash
docker-compose exec myapp php artisan make:controller UserController
```

- Installing a new composer package called phpmailer/phpmailer with version 5.2.\*

```bash
docker-compose exec myapp composer require phpmailer/phpmailer:5.2.*
```
