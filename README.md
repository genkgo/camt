# Genkgo.CAMT

[![Build Status](https://github.com/genkgo/camt/workflows/main/badge.svg)](https://github.com/genkgo/camt/actions)
[![Code Quality](https://scrutinizer-ci.com/g/genkgo/camt/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/genkgo/camt/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/genkgo/camt/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/genkgo/camt/?branch=master)
[![Total Downloads](https://poser.pugx.org/genkgo/camt/downloads.png)](https://packagist.org/packages/genkgo/camt)
[![Latest Stable Version](https://poser.pugx.org/genkgo/camt/v/stable.png)](https://packagist.org/packages/genkgo/camt)
[![License](https://poser.pugx.org/genkgo/camt/license.png)](https://packagist.org/packages/genkgo/camt)

Library to read CAMT files. Currently only CAMT.052, CAMT.053 and CAMT.054 are supported.

### Supported Versions

#### Camt 052

| Version           | Supported          |
| :---------------: | :----------------: |
| camt.052.001.01   | :heavy_check_mark: |
| camt.052.001.02   | :heavy_check_mark: |
| camt.052.001.03   |                    |
| camt.052.001.04   | :heavy_check_mark: |
| camt.052.001.05   |                    |
| camt.052.001.06   | :heavy_check_mark: |

#### Camt 053

| Version           | Supported          |
| :---------------: | :----------------: |
| camt.053.001.01   |                    |
| camt.053.001.02   | :heavy_check_mark: |
| camt.053.001.03   | :heavy_check_mark: |
| camt.053.001.04   | :heavy_check_mark: |
| camt.053.001.05   |                    |
| camt.053.001.06   |                    |

#### Camt 054

| Version           | Supported          |
| :---------------: | :----------------: |
| camt.054.001.01   |                    |
| camt.054.001.02   | :heavy_check_mark: |
| camt.054.001.03   |                    |
| camt.054.001.04   | :heavy_check_mark: |
| camt.054.001.05   |                    |
| camt.054.001.06   |                    |


### Installation

It is installable and autoloadable via Composer:

```sh
composer require genkgo/camt
```

### Quality

To run the unit tests at the command line, run:

```sh
./vendor/bin/phpunit
```

This library attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If
you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

[PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) is used to ensure PSR coding standards are respected.

To fix CS, run:

```sh
./vendor/bin/php-cs-fixer fix
```

A `.php_cs.dist` file in the root directory excludes `vendor` directory from fixing and contains coding standards level wanted (PSR-2).

## Getting Started

Read a CAMT file, and loop through its statements and entries.

```php
<?php
use Genkgo\Camt\Config;
use Genkgo\Camt\Reader;

$reader = new Reader(Config::getDefault());
$message = $reader->readFile(__DIR__.'/Camt053/Stubs/camt053.v2.minimal.xml');
$statements = $message->getRecords();
foreach ($statements as $statement) {
    $entries = $statement->getEntries();
}
```



### XSD validation
   
This library provides a XSD validation for each supported CAMT format. The validation is executed by default. But in some cases, you might want to disable it.

```php
<?php
use Genkgo\Camt\Config;
use Genkgo\Camt\Reader;

$config = Config::getDefault();
$config->disableXsdValidation();

$reader = new Reader($config);
```
   

## Contributing

- Found a bug? Please try to solve it yourself first and issue a pull request. If you are not able to fix it, at least
  give a clear description what goes wrong. We will have a look when there is time.
- Want to see a feature added, issue a pull request and see what happens. You could also file a bug of the missing
  feature and we can discuss how to implement it.
