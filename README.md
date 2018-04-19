#Sample App for TDD
A simple console app to demonstrate TDD using PHPUnit.

>To run application:
```bash
composer install
php calculator.php add 1,2,3
``` 
OR
```bash
php calculator.php multiply 1,2,3
```
>To run the tests
```bash
./vendor/bin/phpunit
```
> To run php metrics
```bash
./vendor/bin/phpmetrics --report-html=reports/pmpm.html ./src
```