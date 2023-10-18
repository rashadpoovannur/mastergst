# Master Gst 


Unofficial Laravel Package for [MASTER GST E INVOICE / EWAY BILL API ](https://mastergst.com).




### Prerequisites
- A minimum of PHP 8.1 is required.


## Installation


```
composer require rashadpoovannur/mastergst
```




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