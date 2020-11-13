# Vending Machine Test

PHP-CLI Vending Machine

## Instalation
```sh
git clone https://github.com/miguelnicolas/h_vm_test.git
cd h_vm_test/docker/
docker-compose up -d # bootsrap Docker container. It may take a while
docker-compose exec app composer update
```
## Run
To access the Machine interface:
```sh
docker-compose exec app php app/index.php
```
There are also some tetst:
```sh
docker-compose exec app php vendor/bin/phpunit
```

## Usage
The Vending Machine comes empty. You may want to refill it. 
E.g.:

    WATER-10, SODA-10, JUICE-10, 1-30, 0.25-30, 0.10-30, 0.05-30, SERVICE
    
### Valid commands
 - SERVICE
 - INSERT-MONEY
 - RETURN-COIN
 - CREDIT
 - GET
 - STATUS
 - EXIT

Type the option *--help* to see how they are used.
E.g.:
    
    GET --help

##### SERVICE
Resets the stocks and sets the quantity of products and change available in the machine

    [PRODUCT_1]-[QTY], [PRODUCT_2]-[QTY], [COIN_1]-[QTY], ..., [COIN_N]-[QTY], SERVICE
E.g.:

    WATER-10, SODA-10, JUICE-10, 1-30, 0.25-30, 0.10-30, 0.05-30, SERVICE
    1-50, 0.25-50, 0.10-50, 0.05-50, SODA-20, SERVICE
##### INSERT-MONEY
INSERT-MONEY command is implicit whenever a user inserts any coin. The command name can be omitted

    [COIN_1], ..., [COIN_N], INSERT-MONEY
    
E.g.:

    1, 0.25, 0.25, 0.10
##### RETURN-COIN
User can get back their money anytime, typing this command

    RETURN-COIN
##### CREDIT
Displays how much credit credit the user has

    CREDIT
##### GET
User selects a product. Coins can be added in the same input

    [COIN_1], [COIN_2], GET-[PRODUCT]
    
E.g.:

    1, 0.25, GET-JUICE
    GET-WATER # uses remaining user credit
##### STATUS
Displays the current status of the machine

    STATUS
##### EXIT
Exits the application and resets the machine

    EXIT