### ishlatish juda oddiy bu buyruqni terminal ga kirib bering
## 1 `cd src`

## 2 `composer install`

## 3 `cp .env.example .env`

## 4 `docker-compose build`

## 5 `docker-compose up -d`

## 6 `docker-compose exec php php artisan migrate --seed`

#### agarda sizda docker o'rnatilmagan bo'lsa iltimos [docker.com](https://docs.docker.com) sayt orqali tanishib chiqing
#### command 1 ishlar bajarilgadan keyin [localhost](http://127.0.0.1:8001) orqali ko'rishingiz mumkin
--- --- ---------------------------------------
## API url ```localhost:8001/api/currency```
```
{
	"valuteID": "R01010",
	"from": "2022-05-05",
	"to": "2022-05-18"
}
```

##### response
```
{
	"data": [
		{
			"valuteId": "R01010",
			"numCode": 36,
			"charCode": "AUD",
			"name": "Австралийский доллар",
			"currency_childes": []
		}
	]
}
```

--- ------------------
## WEB 

#### web oddiy html bootstrap ```[localhost:8001/]```
