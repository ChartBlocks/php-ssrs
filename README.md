php-ssrs
========

PHP library for connecting to SSRS over SOAP

Requirements
-------------------

Although it isn't mandatory to use Composer, without it you will need to set up autoloading or require the invidual classes manually. We *highly* recommend you install php-ssrs using Composer, its easy to get started: https://getcomposer.org/

Dependencies:
* PHP5.4
* PHP curl module (on ubuntu, its `sudo apt-get install php5-curl`)


Installation / Usage
--------------------

The easiest way to use php-ssrs is to install it with composer. To include the library in to your project using composer, run the following command:

```
$ php composer.phar require chartblocks/php-ssrs:~1.0.
```

OR add the following to your composer.json file:

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
