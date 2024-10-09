# Genkgo.CAMT

[![Build Status](https://github.com/genkgo/camt/workflows/main/badge.svg)](https://github.com/genkgo/camt/actions)
[![Code Coverage](https://codecov.io/gh/genkgo/camt/branch/main/graph/badge.svg)](https://codecov.io/gh/genkgo/camt)
[![Total Downloads](https://poser.pugx.org/genkgo/camt/downloads.png)](https://packagist.org/packages/genkgo/camt)
[![Latest Stable Version](https://poser.pugx.org/genkgo/camt/v/stable.png)](https://packagist.org/packages/genkgo/camt)
[![License](https://poser.pugx.org/genkgo/camt/license.png)](https://packagist.org/packages/genkgo/camt)

Library to read CAMT files. Currently only CAMT.052, CAMT.053 and CAMT.054 are supported.

### Supported Versions

#### Camt 052

|     Version     |     Supported      |
|:---------------:|:------------------:|
| camt.052.001.01 | :heavy_check_mark: |
| camt.052.001.02 | :heavy_check_mark: |
| camt.052.001.03 |                    |
| camt.052.001.04 | :heavy_check_mark: |
| camt.052.001.05 |                    |
| camt.052.001.06 | :heavy_check_mark: |
| camt.052.001.08 | :heavy_check_mark: |
| camt.052.001.10 |                    |
| camt.052.001.11 |                    |

#### Camt 053

|     Version     |     Supported      |
|:---------------:|:------------------:|
| camt.053.001.01 |                    |
| camt.053.001.02 | :heavy_check_mark: |
| camt.053.001.03 | :heavy_check_mark: |
| camt.053.001.04 | :heavy_check_mark: |
| camt.053.001.05 |                    |
| camt.053.001.06 |                    |
| camt.053.001.08 | :heavy_check_mark: |
| camt.053.001.10 |                    |
| camt.053.001.11 |                    |

#### Camt 054

|     Version     |     Supported      |
|:---------------:|:------------------:|
| camt.054.001.01 |                    |
| camt.054.001.02 | :heavy_check_mark: |
| camt.054.001.03 |                    |
| camt.054.001.04 | :heavy_check_mark: |
| camt.054.001.05 |                    |
| camt.054.001.06 |                    |
| camt.054.001.08 | :heavy_check_mark: |
| camt.054.001.10 |                    |
| camt.054.001.11 |                    |

### Installation

It is installable and autoloadable via Composer:

```sh
composer require genkgo/camt
```

## Getting Started

Read a CAMT file, and loop through its statements and entries.

```php
<?php
use Genkgo\Camt\Config;
use Genkgo\Camt\Reader;

$reader = new Reader(Config::getDefault());
$message = $reader->readFile('test/data/camt053.v2.minimal.xml');
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


### Quality

To check that everything is as it should be, run:

```sh
composer check
```

To fix code style, run:

```sh
composer check
```

### How to release

1. Create an annotated tag
    1. `git tag -a 1.2.3`
    1. Tag subject must be the version number, eg: `1.2.3`
    1. Tag body must be a copy-paste of the changelog entries
1. Push tag with `git push --tags`, then GitHub Actions will create a GitHub release automatically
