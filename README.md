### ishlatish juda oddiy bu buyruqni terminal ga kirib bering
##1`docker-compose up -d`

#### agarda sizda docker o'rnatilmagan bo'lsa iltimos [docker.com](https://docs.docker.com) sayt orqali tanishib chiqing
#### command 1 bajarilgadan keyin [localhost](http://127.0.0.1:8001) orqali ko'rishingiz mumkin
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
