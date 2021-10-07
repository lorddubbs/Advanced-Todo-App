# SRM-APP

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
php artisan vendor:publish | Select Sanctum
```

## Run Docker
Set up .env with corresponding Docker credentials. App should run on localhost.
```
docker compose up
```

## Clear Cache
```
php artisan config:clear
```

## Run Migrations and Seeders from Docker Container
```
docker exec -it std-app php artisan migrate --seed
```

## Run Unit Tests
```
docker exec -it std-app php artisan test
```

## Generate API DOCS
```
docker exec -it std-app php artisan l5-swagger:generate
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
6. API Authorization and Authentication poweresd by Sanctum.
7.