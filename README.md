php-ssrs
========

PHP library for connecting to SSRS over SOAP

Installation / Usage
--------------------

The easiest way to use php-ssrs is to install it with composer. If you don't want to use composer, you can download the project and autoload it manually.

To include the library in to your project using composer, add the following to your composer.json file:

```json
{
    "require": {
        "chartblocks/php-ssrs": "~1.0."
    }
}
```

See the wiki for information on how to get started!

```php
<?php
$ssrs = new \SSRS\Report('http://server/reportserver/', array('username' => 'thomas', 'password' => 'secureme'));
$ssrs->listChildren('/Report Folder');
```
