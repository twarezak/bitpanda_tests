## Task 1

### Instructions

#### Init project

Go to `1.` folder and then:

- run docker: `docker-compose up -d`
- run docker bash: `docker exec -it 1_php_1 bash`
- run composer in docker: `composer install`
- run migration (will seed the DB): `php artisane migrate`

- to run test: `php artisane test`

- generate documentation json: `php artisan l5-swagger:generate`


#### API documentation
API documentation is available when docker is running on site: `http://127.0.0.1:8060/api/documentation` 


## Task 2

### Instructions

#### Init project

Go to `2.` folder and then:

- run docker: `docker-compose up -d`
- log to docker: `docker exec -it 2_php_1 bash`
- run composer in docker: `composer install`
- run migration (will seed the DB): `php artisane migrate`

### Example request:

```
curl --location --request GET 'http://127.0.0.1:8061/api/transactions?source=db' \
--header 'Accept: application/json'
```
