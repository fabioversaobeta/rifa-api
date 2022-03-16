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

- reset

POST http://localhost:8000/reset

- balance

GET http://localhost:8000/balance?account_id=100

- event

POST http://localhost:8000/event
{
	"type": "deposit",
	"destination": "1",
	"amount": 10
}