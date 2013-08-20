# DataTypes

PHP library defining the DataTypes\DataType class.

[![Build Status](https://secure.travis-ci.org/wikimedia/mediawiki-extensions-DataTypes.png?branch=master)](http://travis-ci.org/wikimedia/mediawiki-extensions-DataTypes)
[![Coverage Status](https://coveralls.io/repos/wikimedia/mediawiki-extensions-DataTypes/badge.png?branch=master)](https://coveralls.io/r/wikimedia/mediawiki-extensions-DataTypes?branch=master)
[![Dependency Status](https://www.versioneye.com/package/php--data-values--data-types/badge.png)](https://www.versioneye.com/package/php--data-values--data-types)

On [Packagist](https://packagist.org/packages/data-values/data-types):
[![Latest Stable Version](https://poser.pugx.org/data-values/data-types/version.png)](https://packagist.org/packages/data-values/data-types)
[![Download count](https://poser.pugx.org/data-values/data-types/d/total.png)](https://packagist.org/packages/data-values/data-types)

## Requirements

* PHP 5.3 or later
* [DataValues](https://www.mediawiki.org/wiki/Extension:DataValues) 0.1 or later
* [DataValues](https://www.mediawiki.org/wiki/Extension:ValueValidators) 0.1 or later

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/data-types` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
DataTypes 1.0:

    {
        "require": {
            "data-values/data-types": "1.0.*"
        }
    }

### Manual

Get the DataTypes code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the DataTypes library by including its entry point:
DataTypes.php.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

DataTypes has been written by the Wikidata team at [Wikimedia Germany](https://wikimedia.de)
for the [Wikidata project](https://wikidata.org/).

## Release notes

### 0.1 (under development)

Initial release with these features:

*

## Links

* [DataTypes on Packagist](https://packagist.org/packages/data-values/data-types)
* [DataTypes on Ohloh](https://www.ohloh.net/p/DataTypesPHP)
* [DataTypes on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:DataTypes)
* [TravisCI build status](https://travis-ci.org/wikimedia/mediawiki-extensions-DataTypes)
* [Latest version of the readme file](https://github.com/wikimedia/mediawiki-extensions-DataTypes/blob/master/README.md)