## Start Laravel Project

- Tests
```
php artisan test
```

- Migrates
```
php artisan migrate
```

- Start Server
```
php artisan serve
```

HOST: localhost 
PORT: 8000

URL: http://localhost:8000/

---------

## Routes

- create ticket

POST http://localhost:8000/v1/createTicket
{
	"name": "",
	"phone": "",
	"quantity": 1
}

- get quantities

GET http://localhost:8000/v1/getQuantities

- get random ticket

GET http://localhost:8000/v1/getRandomTicket