# A TODO APP with an Engine

## Frontend setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run start
```

### Compiles and minifies for production
```
npm run build
```

### Run your unit tests
```
npm run test:unit
```

### Lints and fixes files
```
npm run lint
```

### API URL
```
http://localhost/todo/v1
```

### Customize configuration
This app runs on localhost port 8080, please change if there are conflicts with other services on your computer.






## Backend setup
```
composer install
```

## Publish Packages
```
php artisan vendor:publish | Publish Sanctum, Swagger, Cloudinary Packages 
```

## Run Docker
Configure .env with corresponding Docker credentials. App should run on localhost.
```
docker compose up
```

## Clear Cache
```
docker exec -it std-app php artisan config:clear
```

## Run Migrations and Seeders from Docker Container
```
docker exec -it std-app php artisan migrate --seed
```

## Index Tasks table for Elastic Search
```
docker exec -it std-app php artisan load:task
```

## Generate API DOCS
```
docker exec -it std-app php artisan l5-swagger:generate
```

## Run Unit Tests
```
docker exec -it std-app php artisan test
```

### API DOCS
```
http://localhost/todo/docs
```

### Important Notes
1. REDIS has been configured for MailJobs & Queues, feel free to run different ports from Compose.
2. Monitor your Queue with Supervisor (not compulsory).
3. Users get reminded about their todos through scheduled messages, 1 hour before start time.
4. Create a configuration file for the Scheduler and monitor with Supervisor.
5. API Annotations were written and published with Swagger.
6. API Authorization and Authentication powered by Sanctum.
7. Cloudinary for Image Uploads.
8. Design Pattern: Service-Repositories using Eloquent (This can be switched to use DB Transactions).
9. This app does not cover Paginations, Empty States and Bash Aliases.

