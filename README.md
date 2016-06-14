# Genkgo.CAMT

Library to read CAMT files. Currently only CAMT.053 and CAMT.052 are supported for now.

### Supported Versions

#### Camt 053

| Version           | Supported          |
| :---------------: | :----------------: |
| camt.053.001.01   |                    |
| camt.053.001.02   | :heavy_check_mark: |
| camt.053.001.03   | :heavy_check_mark: |
| camt.053.001.04   | :heavy_check_mark: |
| camt.053.001.05   |                    |
| camt.053.001.06   |                    |

#### Camt 052

| Version           | Supported          |
| :---------------: | :----------------: |
| camt.052.001.01   | :heavy_check_mark: |
| camt.052.001.02   |                    |
| camt.052.001.03   |                    |
| camt.052.001.04   | :heavy_check_mark: |
| camt.052.001.05   |                    |
| camt.052.001.06   |                    |

### Installation

Requires PHP 5.5 or later. There are no plans to support PHP 5.4 or PHP 5.3. In case this is an obstacle for you,
conversion should be no problem. The library is very small.

It is installable and autoloadable via Composer as [genkgo/camt](https://packagist.org/packages/genkgo/camt).

### Quality

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/genkgo/camt/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/genkgo/camt/)
[![Code Coverage](https://scrutinizer-ci.com/g/genkgo/camt/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/genkgo/camt/)
[![Build Status](https://travis-ci.org/genkgo/camt.png?branch=master)](https://travis-ci.org/genkgo/camt)

To run the unit tests at the command line, issue `phpunit -c tests/`. [PHPUnit](http://phpunit.de/manual/) is required.

This library attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If
you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

[PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) is used to ensure PSR coding standards are respected.

To fix CS, just launch

```bash
$ ./vendor/bin/php-cs-fixer fix
```

A `.php_cs` file in the root directory excludes `vendor` directory from fixing and contains coding standards level wanted (PSR-2).

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

## Contributing

- Found a bug? Please try to solve it yourself first and issue a pull request. If you are not able to fix it, at least
  give a clear description what goes wrong. We will have a look when there is time.
- Want to see a feature added, issue a pull request and see what happens. You could also file a bug of the missing
  feature and we can discuss how to implement it.
