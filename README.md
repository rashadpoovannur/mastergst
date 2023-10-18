# phone-pay-php

# Laravel Sample Repo: [Click Here](https://github.com/shibanashiqc/phone-pay-test)

Unofficial Laravel Package for [MASTER GST](https://developer.phonepe.com/v1/docs/api-integration).




### Prerequisites
- A minimum of PHP 8.1 is required.


## Installation


```
composer require rashadpoovannur/mastergst
```


## Documentation

Documentation of PhonePe's API and their usage is available at <https://developer.phonepe.com/v1/docs/api-integration>

## Basic Usage


### Authentication

```php
use Rashadpoovannur\Mastergst\EInvoice;


$einvoice = new EInvoice();
$einvoice->authenticate($ipAddress);


```




### To fetch Gst Details 

```php


$einvoice->gstdetails($gstNumber);


```


## License

The released under the MIT License. See [LICENSE](LICENSE) file for more details.